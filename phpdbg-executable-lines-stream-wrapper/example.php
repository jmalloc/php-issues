#!/usr/bin/env phpdbg -qrr
<?php

/**
 * This example demonstrates how phpdbg_get_executable() behaves differently
 * when passed the 'files' option vs without, in the face of some mild abuse
 * of stream wrappers.
 */

/**
 * First, we define a stream wrapper that simply maps to a real file on disk.
 */
final class StreamWrapper
{
    public function stream_open(
        string $path,
        string $mode,
        int $options = 0,
        string &$openedPath = null
    ) : bool {
        if ($mode[0] !== 'r') {
            return false;
        }

        list($scheme, $path) = explode('://', $path, 2);

        $stream = \fopen($path, $mode);

        if ($stream === false) {
            return false;
        }

        $this->stream = $stream;

        /**
         * The $openedPath reference variable is assigned, indicating the
         * *actual* path that was opened. This affects the behaviour of
         * constants like __FILE__.
         */
        $openedPath = \realpath($path);

        return true;
    }

    public function stream_read(int $count) : string { return \fread($this->stream, $count); }
    public function stream_close() : bool { return \fclose($this->stream); }
    public function stream_eof() : bool { return \feof($this->stream); }
    public function stream_stat() { return \fstat($this->stream); }

    private $stream = false;
}

stream_wrapper_register('wrapper', StreamWrapper::class);

/**
 * Next, we include a PHP file that contains executable lines, via the stream
 * wrapper.
 */
$filename = __DIR__ . '/include.php';
require 'wrapper://' . $filename;

/**
 * If we call phpdbg_get_executable() and pass no options, the realpath of the
 * included file is present in the array, but indicates no executable lines.
 */
$x = phpdbg_get_executable();

// We expect [5 => 0], but get an empty array ...
print_r($x[$filename]);

/**
 * However, if we pass the filename explictly, we get the correct result.
 */
$x = phpdbg_get_executable(['files' => [$filename]]);

// We expect and receive [5 => 0] ...
print_r($x[$filename]);

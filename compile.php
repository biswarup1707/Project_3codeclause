<?php
// Get the code from the POST request
$code = $_POST['code'];

// Create a temporary file to store the code
$filename = tempnam(sys_get_temp_dir(), 'code');
$handle = fopen($filename, 'w');
fwrite($handle, $code);
fclose($handle);

// Compile and execute the code using the appropriate commands
$language = 'cpp'; // 'c' or 'cpp'
$output = '';
$exitCode = 0;

if ($language === 'c') {
  exec("gcc $filename -o $filename.out 2>&1", $output, $exitCode);
  if ($exitCode === 0) {
    exec("./$filename.out 2>&1", $output, $exitCode);
  }
} elseif ($language === 'cpp') {
  exec("g++ $filename -o $filename.out 2>&1", $output, $exitCode);
  if ($exitCode === 0) {
    exec("./$filename.out 2>&1", $output, $exitCode);
  }
}

// Clean up the temporary file
unlink($filename);

// Send the output back to the client
echo implode("\n", $output);
?>

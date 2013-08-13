<?php
define('GPS_BABEL', __DIR__ . '/gpsbabel');

// Get the directory to search recursively for logfiles
$directory = './';
if (isset($argv[1])) 
	$directory = $argv[1];

// Find the .log files in the directory
$findCommand = "find " . escapeshellarg($directory) . " -name '*.log'";
$files = explode("\n", shell_exec($findCommand));

// Convert them, if they don't exist already
foreach($files as $file) {
	$file = trim($file);
	if ($file != '') {
		// Convert to gpx
		$targetFileName = preg_replace("/\.log$/", ".gpx", $file);
		if (!file_exists($targetFileName)) {
			echo "Converting '" . $file . "' to gpx...\n";
			$convertCommand = escapeshellarg(GPS_BABEL) . " -i nmea -o gpx " . escapeshellarg($file) . " " . escapeshellarg($targetFileName);
			shell_exec($convertCommand);
		}

		// Convert to kml
		/*
		$targetFileName = preg_replace("/\.log$/", ".kml", $file);
		if (!file_exists($targetFileName)) {
			echo "Converting '" . $file . "' to kml...\n";
			$convertCommand = escapeshellarg(GPS_BABEL) . " -i nmea -o kml " . escapeshellarg($file) . " " . escapeshellarg($targetFileName);
			shell_exec($convertCommand);
		}
		*/
	}
}

# AmbassadorJS PHP Helpers

![Ambassador IO Logo](https://raw.githubusercontent.com/mgwhitfield/io/master/logo-icon-64.PNG)

PHP Functions used every day in development

## Installation

Each file may be used independently using PHP's include syntax.

## File Descriptions

*  copy_dir -- copy one directory to another (deep copy)
* dates -- helpers for converting timestamps into readable timers  (e.g. 1m since last update)
* deep_json_decode -- for when parts of a JSON object are encoded within a partially decoded object
* get_directory_last_modified -- gets the last modification time for a file using the latest update (default PHP gets only the folder itself which may not reflect folders contents)
* get_json -- gets a file and turns it into a JSON object
* get_json_index -- **see below**
* get_modified_files_since -- gets all files modified in a folder since an inputted time
* goto_dir -- goes to a directory; if directory does not exist, creates it
* read_file_lines -- converts file into array of lines
* rrmdir -- remove directories with multiple subfolders
* rscandir -- read all directory and subdirectory content into array
 *  search_json_index -- **see below**
 *  set_json -- sets a file as a JSON string given an object
 *  set_json_index -- **see below**
 * sfile_get_contents -- get file contents using reliable file locking
 * sfile_put_contents -- put file contents using reliable file locking
 * unzip -- unzips a file to a directory
 * zip -- zips a directory to a file name
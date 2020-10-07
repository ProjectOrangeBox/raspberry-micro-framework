<?php

function EXPORT_DATABASE(string $host, string $user, string $pass, string $name, $tables = false, bool $backup_name = false): void
{
  set_time_limit(3000);
  $mysqli = new mysqli($host, $user, $pass, $name);
  $mysqli->select_db($name);
  $mysqli->query("SET NAMES 'utf8'");
  $queryTables = $mysqli->query('SHOW TABLES');

  while ($row = $queryTables->fetch_row()) {
    $target_tables[] = $row[0];
  }

  if ($tables !== false) {
    $target_tables = array_intersect($target_tables, $tables);
  }

  $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $name . "`\r\n--\r\n\r\n\r\n";

  foreach ($target_tables as $table) {
    if (empty($table)) {
      continue;
    }

    $result  = $mysqli->query('SELECT * FROM `' . $table . '`');
    $fields_amount = $result->field_count;
    $rows_num = $mysqli->affected_rows;
    $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
    $TableMLine = $res->fetch_row();
    $content .= "\n\n" . $TableMLine[1] . ";\n\n";
    $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);

    for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
      while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
        if ($st_counter % 100 == 0 || $st_counter == 0) {
          $content .= "\nINSERT INTO " . $table . " VALUES";
        }
        $content .= "\n(";
        for ($j = 0; $j < $fields_amount; $j++) {
          $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
          if (isset($row[$j])) {
            $content .= '"' . $row[$j] . '"';
          } else {
            $content .= '""';
          }
          if ($j < ($fields_amount - 1)) {
            $content .= ',';
          }
        }
        $content .= ")";
        //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
        if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
          $content .= ";";
        } else {
          $content .= ",";
        }
        $st_counter = $st_counter + 1;
      }
    }
    $content .= "\n\n\n";
  }

  $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
  $backup_name = $backup_name ? $backup_name : $name . '___(' . date('H-i-s') . '_' . date('d-m-Y') . ').sql';

  ob_get_clean();
  header('Content-Type: application/octet-stream');
  header("Content-Transfer-Encoding: Binary");
  header('Content-Length: ' . (function_exists('mb_strlen') ? mb_strlen($content, '8bit') : strlen($content)));
  header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
  echo $content;

  exit;
}

function IMPORT_TABLES(string $host, string $user, string $pass, string $dbname, string $sql_file_OR_content): bool
{
  set_time_limit(3000);

  $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ?  $sql_file_OR_content : file_get_contents($sql_file_OR_content));
  $allLines = explode("\n", $SQL_CONTENT);
  $mysqli = new mysqli($host, $user, $pass, $dbname);

  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  $zzzzzz = $mysqli->query('SET foreign_key_checks = 0');
  preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $SQL_CONTENT, $target_tables);

  foreach ($target_tables[2] as $table) {
    $mysqli->query('DROP TABLE IF EXISTS ' . $table);
  }

  $zzzzzz = $mysqli->query('SET foreign_key_checks = 1');
  $mysqli->query("SET NAMES 'utf8'");
  $templine = '';  // Temporary variable, used to store current query

  foreach ($allLines as $line) { // Loop through each line
    if (substr($line, 0, 2) != '--' && $line != '') {
      $templine .= $line; // (if it is not a comment..) Add this line to the current segment
      if (substr(trim($line), -1, 1) == ';') { // If it has a semicolon at the end, it's the end of the query
        if (!$mysqli->query($templine)) {
          print('Error performing query \'<strong>' . $templine . '\': ' . $mysqli->error . '<br /><br />');
        }
        $templine = ''; // set variable to empty, to start picking up the lines after ";"
      }
    }
  }

  echo 'Importing finished. Now, Delete the import file.';

  return true;
}

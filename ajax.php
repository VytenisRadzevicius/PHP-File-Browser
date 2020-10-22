<?php
// Check the requests
if(isset($_POST['action'])) $action = $_POST['action']; else $action = '';
if(isset($_POST['path'])) $path = $_POST['path']; else $path = '';

function getFolder($p) { // Return data of the directory
  if(is_dir($p)) {
  $data = array_slice(scandir($p), 2);

  if(!empty($data)) { // Get the data
    $dataArr['type'] = 'folder';
    foreach ($data as $value) {
      $dataArr['data'][] = array(
      is_file($p . '\\' . $value) ? 'file' : 'folder',
      $value,
      mime_content_type($p . '\\' . $value),
      is_file($p . '\\' . $value) ? filesize($p . '\\' . $value) : null,
      is_file($p . '\\' . $value) ? 'open' : null
      );
    }
  } else { // Data is empty
    $dataArr['type'] = 'empty';
    $dataArr['data'][] = array('empty', '', '', '', ''); }
  }

  return $dataArr;
}

function getFile($p) {// Return data of a file
  if(is_file($p)) {
    $dataArr['type'] = explode('/', mime_content_type($p))[0];
    $dataArr['name'] = array_slice(explode('\\', $p), -1);
    if($dataArr['type'] == 'text') $dataArr['data'][] = htmlspecialchars(file_get_contents($p));
    if($dataArr['type'] == 'image') $dataArr['data'][] = $p;
  }
  return $dataArr;
}

function createFolder($p) {
  if(isset($_POST['item'])) {
    $dir = $p . '\\' . $_POST['item'];
    if (!is_dir($dir)) { 
      mkdir($dir);
      $dataArr['type'] = 'success';
      $dataArr['name'] = $_POST['item'];
    } else {
      $dataArr['type'] = 'error';
    }
  }
  return $dataArr;
}

switch ($action) { // Carry out the action
  case 'folder':
    $dataArr = getFolder($path);
  break;

  case 'file':
    $dataArr = getFile($path);
    break;

  case 'create':
    $dataArr = createFolder($path);
    break;

  default:
    echo 'Nope!';
}

if(!empty($dataArr)) echo json_encode($dataArr); // Response
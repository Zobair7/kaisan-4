<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php

/**
* Prepend the base_url.
*/
function base_url($url) 
{
  return CKaisan::Instance()->request->base_url . trim($url, '/');
}

/**
* Create a url to an internal resource.
*/
function create_url($url=null) 
{
  return CKaisan::Instance()->request->CreateUrl($url);
}

/**
* Prepend the theme_url, which is the url to the current theme directory.
*/
function theme_url($url) 
{
  $ka = CKaisan::Instance();
  return "{$ka->request->base_url}themes/{$ka->config['theme']['name']}/{$url}";
}


/**
* Return the current url.
*/
function current_url() 
{
  return CKaisan::Instance()->request->current_url;
}

/**
* Print debuginformation from the framework.
*/
function get_debug() 
{
  // Only if debug is wanted.
  $ka = CKaisan::Instance();
  if(empty($ka->config['debug'])) 
  {
    return;
  }
  
  // Get the debug output
  $html = null;
  if(isset($ka->config['debug']['db-num-queries']) && $ka->config['debug']['db-num-queries'] && isset($ka->db)) 
  {
    $flash = $ka->session->GetFlash('database_numQueries');
    $flash = $flash ? "$flash + " : null;
    $html .= "<p>Database made $flash" . $ka->db->GetNumQueries() . " queries.</p>";
  }
  if(isset($ka->config['debug']['db-queries']) && $ka->config['debug']['db-queries'] && isset($ka->db)) 
  {
    $flash = $ka->session->GetFlash('database_queries');
    $queries = $ka->db->GetQueries();
    if($flash) 
    {
      $queries = array_merge($flash, $queries);
    }
    $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $queries) . "</pre>";
  }
  if(isset($ka->config['debug']['timer']) && $ka->config['debug']['timer']) 
  {
    $html .= "<p>Page was loaded in " . round(microtime(true) - $ka->timer['first'], 5)*1000 . " msecs.</p>";
  }
  if(isset($ka->config['debug']['kaisan']) && $ka->config['debug']['kaisan']) 
  {
    $html .= "<hr><h3>Debuginformation</h3><p>The content of CKaisan:</p><pre>" . htmlent(print_r($ka, true)) . "</pre>";
  }
  if(isset($ka->config['debug']['session']) && $ka->config['debug']['session']) 
  {
    $html .= "<hr><h3>SESSION</h3><p>The content of CKaisan->session:</p><pre>" . htmlent(print_r($ka->session, true)) . "</pre>";
    $html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
  }
  return $html;
}

/**
* Render all views.
*/
function render_views() 
{
  return CKaisan::Instance()->views->Render();
}

/**
* Get messages stored in flash-session.
*/
function get_messages_from_session() 
{
  $messages = CKaisan::Instance()->session->GetMessages();
  $html = null;
  if(!empty($messages)) 
  {
    foreach($messages as $val) 
    {
      $valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
      $class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
      $html .= "<div class='$class'>{$val['message']}</div>\n";
    }
  }
  return $html;
}

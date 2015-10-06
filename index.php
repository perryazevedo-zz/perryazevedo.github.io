<?php
  $str_browser_language = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
  $str_browser_language = !empty($_GET['language']) ? $_GET['language'] : $str_browser_language;
  switch (substr($str_browser_language, 0,2))
  {
    case 'de':
      $str_language = 'de';
      break;
    case 'en':
      $str_language = 'en';
      break;
    default:
      $str_language = 'en';
  }

  $arr_available_languages = array();
  $arr_available_languages[] = array('str_name' => 'English', 'str_token' => 'en');
  $arr_available_languages[] = array('str_name' => 'Deutsch', 'str_token' => 'de');

  $str_available_languages = (string) '';
  foreach ($arr_available_languages as $arr_language)
  {
    if ($arr_language['str_token'] !== $str_language)
    {
      $str_available_languages .= '<a href="'.strip_tags($_SERVER['PHP_SELF']).'?language='.$arr_language['str_token'].'" lang="'.$arr_language['str_token'].'" xml:lang="'.$arr_language['str_token'].'" hreflang="'.$arr_language['str_token'].'">'.$arr_language['str_name'].'</a> | ';
    }
  }
  $str_available_languages = substr($str_available_languages, 0, -3);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head lang="<?php echo $str_language; ?>" xml:lang="<?php echo $str_language; ?>">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Globe Demo</title>

    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/three.js/r63/three.min.js"></script>

  </head>

  <body>

  <script id="vertexShader" type="x-shader/x-vertex">
      uniform vec3 viewVector;
      uniform float c;
      uniform float p;
      varying float intensity;

      void main({
          vec3 vNormal = normalize( normalMatrix * normal );
          vec3 vNormel = normalize( normalMatrix * viewVector );
          intensity = pow( c - dot(vNormal, vNormel), p );

          gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
      }
  </script>

  <script id="fragmentShader" type="x-shader/x-fragment">
      uniform vec3 glowColor;
      varying float intensity;

  void main() {
      vec3 glow = glowColor * intensity;
      gl_FragColor = vec4( glow, 1.0 );
  }
  </script>

    <script src="scripts/earth.js"></script>

  </body>
  </html>

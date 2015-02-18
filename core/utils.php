<?php
namespace fixate;

class Strings
{
	static function camel_case($str, $first_capital = true)
	{
		if ($first_capital) {
			$str[0] = strtoupper($str[0]);
		}
		$func = create_function('$c', 'return strtoupper($c[1]);');
	return preg_replace_callback('/_([a-z])/', $func, $str);
	}

	static function snake_case($str)
  {
		preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
		$ret = $matches[0];
		foreach ($ret as &$match) {
			$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
		}
		return implode('_', $ret);
	}

	static function rchomp($str, $chomp)
  {
		if (!self::ends_with($str, $chomp)) {
			return $str;
		}

		$cmp_len = strlen($chomp);
		$len = strlen($str);
		return substr($str, 0, $len - $cmp_len);
	}

	static function pad_left($str, $pad_num, $chr = ' ')
  {
    $str_diff = $pad_num - strlen($str);

    if ($str_diff < 0)
      return $str;

    for ($i = 0; $i < $str_diff; $i++)
      {
        $str = $chr . $str;
      }

    return $str;
  }

  static function pad_right($str, $pad_num, $chr = ' ')
  {
    $str_diff = $padnum - strlen($str);
    if ($str_diff < 0)
      return $str;

    for ($i = 0; $i < $str_diff; $i++)
      $str = $str . $chr;

    return $str;
  }

  static function ends_with($haystack, $needle)
  {
    return strrpos($haystack, $needle) === strlen($haystack)-strlen($needle);
  }

  static function starts_with($haystack, $needle)
  {
    if (is_array($needle))
    {
      foreach ($needle as $i)
        if (strpos($haystack, $i) === 0)
          return true;
      return false;
    }

    return strpos($haystack, $needle) === 0;
  }

	static function slugify($str, $unicode_repl = true)
  {
		$str = str_replace('\'', '', trim($str));
		if ($unicode_repl) {
			$str = strtr($str, array(
				'À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Å'=>'A','Ä'=>'A','Æ'=>'AE',
				'à'=>'a','á'=>'a','â'=>'a','ã'=>'a','å'=>'a','ä'=>'a','æ'=>'ae',
				'Þ'=>'B','þ'=>'b','Č'=>'C','Ć'=>'C','Ç'=>'C','č'=>'c','ć'=>'c',
				'ç'=>'c','Ď'=>'D','ð'=>'d','ď'=>'d','Đ'=>'Dj','đ'=>'dj','È'=>'E',
				'É'=>'E','Ê'=>'E','Ë'=>'E','è'=>'e','é'=>'e','ê'=>'e','ë'=>'e',
				'Ì'=>'I','Í'=>'I','Î'=>'I','Ï'=>'I','ì'=>'i','í'=>'i','î'=>'i',
				'ï'=>'i','Ľ'=>'L','ľ'=>'l','Ñ'=>'N','Ň'=>'N','ñ'=>'n','ň'=>'n',
				'Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ø'=>'O','Ö'=>'O','Œ'=>'OE',
				'ð'=>'o','ò'=>'o','ó'=>'o','ô'=>'o','õ'=>'o','ö'=>'o','œ'=>'oe',
				'ø'=>'o','Ŕ'=>'R','Ř'=>'R','ŕ'=>'r','ř'=>'r','Š'=>'S','š'=>'s',
				'ß'=>'ss','Ť'=>'T','ť'=>'t','Ù'=>'U','Ú'=>'U','Û'=>'U','Ü'=>'U',
				'Ů'=>'U','ù'=>'u','ú'=>'u','û'=>'u','ü'=>'u','ů'=>'u','Ý'=>'Y',
				'Ÿ'=>'Y','ý'=>'y','ý'=>'y','ÿ'=>'y','Ž'=>'Z','ž'=>'z'
			));
		}

		return trim(strtolower(preg_replace('/([^\w]|-)+/', '-', trim($str))));
	}
}

class Php
{
	static function require_all($path, $ext = 'php')
  {
		$requires = Files::ls($path, $ext);
		foreach ($requires as $f) {
			require Paths::join($path, $f);
		}
	}
}

class Files
{
	static function ls($path, $extension = null)
  {
    $result = array();
    if ($handle = opendir($path))
      while (($file = readdir($handle)) !== false)
      {
        if (is_dir("$path/$file"))
          continue;

        if ($extension && Paths::get_extension($file) != $extension)
          continue;

        $result[] = $file;
      }

    if (isset($handle))
      closedir($handle);

    return $result;
  }

  static function parse_json_file($filename)
  {
  	return json_decode(file_get_contents($filename), true);
  }
}

class Paths
{
	static function get_filename($path)
  {
    $arrStr = explode("/", $path);
    $arrStr = array_reverse($arrStr);

    return $arrStr[0];
  }

  static function get_filename_without_extension($path, $preserve_path = false)
  {
		if ($preserve_path) {
			return self::join(pathinfo($path, PATHINFO_DIRNAME), pathinfo($path, PATHINFO_FILENAME));
		}

		return pathinfo($path, PATHINFO_FILENAME);
  }

  static function get_extension($path)
  {
		return strtolower(pathinfo($path, PATHINFO_EXTENSION));
  }

	static function join()
  {
    $_args = func_get_args();
    $path = rtrim($_args[0], '/');
    for ($i = 1; $i < count($_args);$i++)
      $path = "$path/".trim($_args[$i], '/');

    return $path;
  }

	static function resolve($path)
  {
		return realpath($path);
	}

	static function change_extension($path, $ext)
  {
		return self::get_filename_without_extension($path, true).'.'.trim($ext, '.');
	}
}

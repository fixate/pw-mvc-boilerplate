<?php
namespace fixate;

class Strings {
	static function camel_case($str, $first_capital = true) {
		if ($first_capital) {
      $str[0] = strtoupper($str[0]);
    }
    $func = create_function('$c', 'return strtoupper($c[1]);');
    return preg_replace_callback('/_([a-z])/', $func, $str);
	}

	static function snake_case($str) {
		preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
		$ret = $matches[0];
		foreach ($ret as &$match) {
			$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
		}
		return implode('_', $ret);
	}

	static function rchomp($str, $chomp) {
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
}

class Php {
	static function require_all($path, $ext = 'php') {
		$requires = Files::ls($path, $ext);
		foreach ($requires as $f) {
			require Paths::join($path, $f);
		}
	}
}

class Files {
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
}

class Paths {
	static function get_filename($path)
  {
    $arrStr = explode("/", $path);
    $arrStr = array_reverse($arrStr);

    return $arrStr[0];
  }

  static function get_filename_without_extension($path)
  {
    return substr($path, 0, strrpos($path, '.'));
  }

  static function get_extension($path)
  {
    return end(explode(".", $path));
  }

	static function join()
  {
    $_args = func_get_args();
    $path = rtrim($_args[0], '/');
    for ($i = 1; $i < count($_args);$i++)
      $path = "$path/".trim($_args[$i], '/');

    return $path;
  }

	static function resolve($path) {
		return realpath($path);
	}
}


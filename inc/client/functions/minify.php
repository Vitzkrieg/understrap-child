<?php

/**
 * Class to minify HTML
 *
 * @link  https://gist.github.com/sethbergman/d07e879200bef6862131
 */
class WP_HTML_Compression
{
  // Settings
  protected $compress_css = true;
  protected $compress_js = true;
  protected $info_comment_html = false;
  protected $inline_tags = "(<a|<abbr|<acronym|<b|<bdo|<big|<br|<button|<cite|<code|<dfn|<em|<i|<img|<input|<kbd|<label|<map|<object|<output|<q|<samp|<select|<small|<span|<strong|<sub|<sup|<textarea|<time|<tt|<u|<var|/>)";

  // Variables
  protected $html;

  public function __construct($html)
  {
    if (!empty($html)) {
      $this->parseHTML($html);
    }
  }

  public function __toString()
  {
    return $this->html;
  }

  protected function bottomComment($raw, $compressed)
  {
    $raw = strlen($raw);
    $compressed = strlen($compressed);

    $savings = (($raw - $compressed) / $raw) * 100;

    $savings = round($savings, 2);

    return "<!--HTML compressed, size saved " .
      $savings .
      "%. From " .
      $raw .
      " bytes, now " .
      $compressed .
      " bytes-->";
  }

  protected function minifyHTML($html)
  {
    $pattern =
      '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
    preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
    $overriding = false;
    $raw_tag = false;
    $strip_js = false;
    $closeTag = "</script>";
    // Variable reused for output
    $html = "";
    foreach ($matches as $token) {
      $tag = isset($token["tag"]) ? strtolower($token["tag"]) : null;

      $content = $token[0];

      if (is_null($tag)) {
        if (!empty($token["script"])) {
          if ($this->compress_js) {
            $strip_js = strpos($content, $closeTag) != false;
            if ($strip_js) {
              $openTagEndPos = strpos($content, ">") + 1;
              $openTag = substr($content, 0, $openTagEndPos);
              $code = substr($content, $openTagEndPos);
              $code = $this->minifyJS($code);
              $content = $openTag . $code;
            }
            $content = trim($content);
          }
        } elseif (!empty($token["style"])) {
          $strip = $this->compress_css;
        } elseif ($content == "<!--wp-html-compression no compression-->") {
          $overriding = !$overriding;

          // Don't print the comment
          continue;
        } elseif (!is_local() && !$overriding && $raw_tag != "textarea") {
          // Remove any HTML comments, except MSIE conditional comments
          $content = preg_replace(
            "/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s",
            "",
            $content
          );
        }
      } else {
        if ($tag == "pre" || $tag == "textarea") {
          $raw_tag = $tag;
        } elseif ($tag == "/pre" || $tag == "/textarea") {
          $raw_tag = false;
        } else {
          if ($raw_tag || $overriding) {
            $strip = false;
          } else {
            $strip = true;

            // Remove any empty attributes, except:
            // action, alt, content, src
            $content = preg_replace(
              '/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/',
              '$1',
              $content
            );

            // Remove any space before the end of self-closing XHTML tags
            // JavaScript excluded
            $content = str_replace(" />", "/>", $content);
          }
        }
      }

      if ($strip_js) {
        $strip_js = false;
      } else if ($strip) {
        $content = $this->condenseHTML($content);
      }

      $html .= $content;
    }

    $html = $this->condenseTags($html);
    $html = trim($html);

    return $html;
  }

  public function parseHTML($html)
  {
    $this->html = $this->minifyHTML($html);

    if ($this->info_comment_html) {
      $this->html .= "\n" . $this->bottomComment($html, $this->html);
    }
  }

  protected function condenseHTML($str)
  {
    $search = ["/\>[^\S ]+/s", "/[^\S ]+\</s", "/(\s)+/s"];
    $replace = [">", "<", '\\1'];
    $str = preg_replace($search, $replace, $str);
    
    $str = $this->removeWhiteSpace($str);
    $str = $this->condenseTags($str);

    return $str;
  }

  protected function removeWhiteSpace($str)
  {
    $str = str_replace(["\r\n", "\r", "\n"], "", $str);
    $str = str_replace(["\t"], " ", $str);
    $str = preg_replace("/(\s+)/m", " ", $str);

    return $str;
  }

  protected function minifyJS($str)
  {
    // Set placeholders for urls
    $str = preg_replace("/http:\/\//","___http___",$str);
    $str = preg_replace("/https:\/\//","___https___",$str);

    // Remove single-line comments
    $str = preg_replace('/\/\/[^\n]*/', "", $str);

    // Remove multi-line comments
    $str = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $str);
    $str = preg_replace("/\/\*[^\/]*\*\//", "", $str);
    $str = preg_replace("/\/\*\*((\r\n|\n) \*[^\n]*)+(\r\n|\n) \*\//", "", $str);

    // Remove tabs, newlines & returns
    $str = $this->removeWhiteSpace($str);

    // Replace placeholder urls
    $str = preg_replace("/___http___/","http://",$str);
    $str = preg_replace("/___https___/","https://",$str);

    return $str;
  }

  protected function condenseTags($str) {
    if (preg_match($this->inline_tags, $str)) {
      return $str;
    }
    return preg_replace("/\>\s+\</m", "><", $str);;
  }
}

function wp_html_compression_finish($html)
{
  do_action('ihk_minify_before', $html);
  $minified = new WP_HTML_Compression($html);
  do_action('ihk_minify_after', $minified, $html);
  return $minified;
}

function wp_html_compression_start()
{
  ob_start("wp_html_compression_finish");
}

add_action('get_header', 'wp_html_compression_start');

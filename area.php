<?php

/******************************************************************************
 *                                                                            *
 *   area.php, v 0.00 2007/07/23 - This is part of xBB library                *
 *   Copyright (C) 2006-2007  Dmitriy Skorobogatov  dima@pc.uz                *
 *                                                                            *
 *   This program is free software; you can redistribute it and/or modify     *
 *   it under the terms of the GNU General Public License as published by     *
 *   the Free Software Foundation; either version 2 of the License, or        *
 *   (at your option) any later version.                                      *
 *                                                                            *
 *   This program is distributed in the hope that it will be useful,          *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of           *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            *
 *   GNU General Public License for more details.                             *
 *                                                                            *
 *   You should have received a copy of the GNU General Public License        *
 *   along with this program; if not, write to the Free Software              *
 *   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA *
 *                                                                            *
 ******************************************************************************/

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>xBBArea</title>
<meta name="author" content="Dmitriy Skorobogatov" />
<style type="text/css">
body {
    font-family: 'Monaco', 'Courier New', monospace;
    color: #000000;
    margin: 0px;
    padding: 0px;
}
span.bb_spec_char {
    color: #000099;
}
span.bb_mnemonic {
    color: #ff0000;
}
span.bb_tag {
    color: #009900;
}
span.bb_bracket {
    font-weight: bold;
}
span.bb_slash {
    font-weight: normal;
}
span.bb_tagname {
    color: #990099;
}
span.bb_equal {
    color: #999900;
}
span.bb_quote {
    color: #009999;
}
span.bb_attrib_name {
    color: #999900;
}
span.bb_attrib_val {
    color: #009999;
}
span.bb_autolink {
    color: #0000ff;
}
</style>
<script type="text/javascript">
onload = function() {
    document.designMode = 'on';
    // Для Gecko устанавливаем такой режим, чтобы форматирование ставилось
    // тегами, а не стилями. Чтобы MSIE не выдавал ошибку, прячем это в
    // конструкцию try-catch
    try {
        document.execCommand("useCSS", false, true);
    } catch(e) {}
}
</script>
</head>
<body contenteditable="true"></body>
</html>

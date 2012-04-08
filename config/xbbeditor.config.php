<?php

/******************************************************************************
 *                                                                            *
 *   xbbeditor.config.php, v 0.00 2007/07/25 - This is part of xBB library    *
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

// Умолчальные значения настроек xBBEditor-а

// Список шрифтов, предлагаемых на выбор пользователя
$fonts = array(
    'Arial'          ,
    'Courier'        ,
    'Geneva'         ,
    'Impact'         ,
    'Optima'         ,
    'Times New Roman',
    'Verdana'        ,
    'Tahoma'         ,
    'Symbol'
);
// Палитра цветов, предлагаемых на выбор пользователя
$colors = array(
    array('Black',  'Maroon',  'Green',  'Navy'),
    array('Silver', 'Red',     'Lime',   'Blue'),
    array('Gray',   'Purple',  'Olive',  'Teal'),
    array('White',  'Fuchsia', 'Yellow', 'Aqua')
);
// Основные смайлики, предлагаемые на выбор пользователя
$smiles = array(
    array(
        array('1.gif' , ':D'     ),
        array('2.gif' , ':)'     ),
        array('3.gif' , ':('     ),
        array('4.gif' , ':heap:' ),
        array('5.gif' , ':ooi:'  ),
    ),
    array(
        array('6.gif' , ':so:'   ),
        array('7.gif' , ':surp:' ),
	    array('8.gif' , ':ag:'   ),
	    array('9.gif' , ':ir:'   ),
	    array('10.gif', ':oops:' ),
    ),
	array(
	    array('11.gif', ':P'     ),
	    array('12.gif', ':cry:'  ),
	    array('13.gif', ':rage:' ),
	    array('15.gif', ':roll:' ),
	    array('16.gif', ':wink:' ),
	),
	array(
	    array('17.gif', ':yes:'  ),
	    array('18.gif', ':bot:'  ),
	    array('19.gif', ':z)'    ),
	    array('20.gif', ':arrow:'),
	    array('41.gif', ':lol:'  ),
	),
	array(
	    array('58.gif', ':heart:'),
	    array('64.gif', ':gift:' ),
	    array('74.gif', ':pnk:'  ),
	),
);

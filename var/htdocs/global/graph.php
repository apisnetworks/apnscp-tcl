<?php    
    /*
    *  Graph class
    *  Provides various graph alternatives to the standard
    *  continuous bar, for use with apnscp
    */
    error_reporting(E_ALL);
    class Graph  {
        
        var $data;      // our data
        var $color;     // color data
        var $image;     // image data if it's continuous or discrete
        var $config;    // associative array of configuration values
        var $sizeX;     // width of the final image
        var $sizeY;     // height of the final image
        var $canvas;    // canvas to hold the image
        var $gdExists;  // internal variable to check whether GD is available
        var $aaFactor;  // to what ratio will we blow it up?
                        // *warning* values != 3 may cause distortion
        var $imageHTML; // HTML'ized version of our image
        
        function Graph($sizeX, $sizeY) {   
            /* fall through to dl()'ing the module *if* available */
            $this->gdExists = 1;
            if (!extension_loaded("gd")) {
                if (!file_exists(PHP_EXTENSION_DIR.'/gd.'.PHP_SHLIB_SUFFIX) ||
                    !dl('gd.'.PHP_SHLIB_SUFFIX)) {
                        //ErrorLog::RaiseNotice("GD Library not found, only continuous graph is available");
                        $this->gdExists = 0;
                }
            }
            // destroy everything if it existed beforehand
            $this->data  = array();
            $this->color = array();
            $this->image = array();
            if (!isset($this->aaFactor)) $this->aaFactor = 3;
            $this->sizeX = $sizeX; $this->sizeY = $sizeY;
            if ($this->gdExists) {
                $this->canvas = imagecreatetruecolor($this->sizeX,$this->sizeY);    
            }

            // allocation for pie and 3D pie
            $this->SetColor("background", 255,255,255);
            $this->SetColor("free", 230,230, 230);
            $this->SetColor("used", 116,141, 75);
            $this->SetColor("shadow", 210,210, 210);
            $this->SetColor("outline", 0,0,0);
        }
        
        function SetColor($mObj, $mRed, $mGreen, $mBlue) {
            if (!array_key_exists($mObj,$this->data) && $mObj != "background" &&
                $mObj != "outline" && $mObj != "text" && $mObj != "shadow" &&
                $mObj != "free" && $mObj != "used") {
				prntf('Nope, no go');
                //ErrorLog::RaiseNotice("Color allocated for non-existent data type '".$mObj."'");
            }
            if ($mRed > 255 || $mBlue > 255 || $mRed > 255) {
				printf('Out of range');
                //ErrorLog::RaiseNotice("Image value out of acceptable range, 0 <= color <= 255");
            }
            $this->color[$mObj] = array("red" => $mRed, "green" => $mGreen, "blue" => $mBlue);
	        }
        
        function SetImage($mObj, $mImage) {
            if (!array_key_exists($mObj,$this->data) && $mObj != "used"
                && $mObj != "free") {
                //ErrorLog::RaiseNotice("Image configured for non-existent data type '".$mObj."'");
            }
            $this->image[$mObj] = $mImage;
        }
        
        function DrawGraph($mType, $mFlags = 0x0000, $mFileName = NULL) {
            if (sizeof($this->data) == 0) {
                //ErrorLog::RaiseWarning("No data to process, cannot draw graph");
                return false;
            }
            switch ($mType) {
                case GRAPH_DISCRETE:
                    $this->GraphDiscrete($mFlags);
                    break;
                case GRAPH_CONTINUOUS:
                    $this->GraphContinuous($mFlags);
                    break;
                case GRAPH_PIE:
                    $this->GraphPie($mFlags,$mFileName);
                    break;
                case GRAPH_PIE_3D:
                    $this->GraphPie3D($mFlags,$mFileName);
                    break;
                default:
                    /*ErrorLog::RaiseNotice("Unknown graph option type, ".
                                          "reverting to continuous graph");*/
                    $this->GraphContinuous($mFlags);
                    break;
            }
            
        }
        
        function DisplayImage(&$rCanvas, $mFileName) {
            if ($mFileName != NULL) {
				imagepng($rCanvas,'/usr/apnscp/var/htdocs/images/graphs/'.$mFileName);
                //imagepng($rCanvas, rtrim(APNSCP_INSTALL_PATH,'/').'/tmp/graphs/'.$mFileName);
                imagedestroy($rCanvas);
                $this->imageHTML = '<img src="/images/graphs/'.$mFileName.'" alt="Graph Data" />';
            }
            else {
                imagepng($rCanvas);
                imagedestroy($rCanvas);
            }
        }
        
        function GraphContinuous($mFlags) {
            $graphData = "";
            if (sizeof($this->data) != 2) {
                /*ErrorLog::RaiseError("Continuous graph option may only ".
                                     "contain two values, ".sizeof($this->data)." values listed");*/
            }
            // convert to rgb values since they'll be HTML color values instead of rgb
            foreach (array("background", "outline") as $colorObj) {
                $rgbStr = "";
                foreach ($this->color[$colorObj] as $colorName => $rgbValue)
                    $rgbStr .= dechex($rgbValue);
                $this->color[$colorObj] = $rgbStr;
            }
            $totalSize = array_sum($this->data);
            $this->imageHTML = '<table width="'.$this->sizeX.'" border=0 '.
                         'cellspacing=0 cellpadding=0 bgcolor="#'.
                         $this->color['background'].'" ';
            if (($mFlags & OPTION_OUTLINE) == OPTION_OUTLINE)
                $this->imageHTML .= 'style="border: 1px solid #'.$this->color['outline'].';" ';
            $this->imageHTML .= '><tr>';
            foreach ($this->data as $name => $value) {
                $this->imageHTML .= '<td height="'.$this->sizeY.
                                    '" valign=middle align=center class=nospacing width="'.
                                    ceil($value/$totalSize*100).'%"><img src="images/c'.
                                    (isset($this->image[$name]) ? $this->image[$name] : $name.'.gif').
                                    '" alt="'.$name.'" height="'.$this->sizeY.
                                    '" width="100%" /></td>';
            }
            $this->imageHTML .= '</td></tr></table>'."\n";
            
            
        }
        function GraphDiscrete($mFlags) {
            // this will hold the HTML for our discrete graph
            $graphData = "";
            if (sizeof($this->data) != 2) {
                //ErrorLog::RaiseError("Discrete graph option may only contain two values, ".sizeof($this->data)." values listed");
            }
            // convert to rgb values since they'll be HTML color values instead of rgb
            foreach (array("background", "outline") as $colorObj) {
                $rgbStr = "";
                foreach ($this->color[$colorObj] as $colorName => $rgbValue)
                    $rgbStr .= dechex($rgbValue);
                $this->color[$colorObj] = $rgbStr;
            }
            if (sizeof($this->image) == 0) {
                foreach ($this->data as $name => $value)
                    $this->image[$name] = 'd'.$name.'.gif';
            }
            foreach ($this->image as $name => $value) {
                switch (strtolower(array_pop(explode(".",basename($value))))) {
                    case "png":
                        $canvas = imagecreatefrompng(rtrim(APNSCP_INSTALL_PATH,'/').'/skins/active/images/'.$value);
                        break;
                    case "gif":
                        $canvas = imagecreatefromgif(rtrim(APNSCP_INSTALL_PATH,'/').'/skins/active/images/'.$value);
                        break;
                    case "jpg":
                    case "jpeg":
                            $canvas = imagecreatefromgif(rtrim(APNSCP_INSTALL_PATH,'/').'/skins/active/images/'.$value);
                        break;
                    default:
                        //ErrorLog::RaiseError("Unknown extension type '".array_pop(explode(".",basename($value)))."' for file '".$value."'");
                        break;
                        
                }
                $sX[$name] = imagesx($canvas);
                $sY[$name] = imagesy($canvas);
                imagedestroy($canvas);
            }
            $totalSize = array_sum($this->data);
            $this->imageHTML = '<table width="'.$this->sizeX.'" "'.
                               'cellspacing=0 cellpadding=0 border=0 '.
                               'bgcolor="#'.$this->color['background'].'" ';
            if (($mFlags & 'OPTION_OUTLINE') == 'OPTION_OUTLINE')
                $this->imageHTML .= 'style="border: 1px solid #'.$this->color['outline'].';" ';
            $this->imageHTML .= '><tr><td height="'.$this->sizeY.'" valign=middle align=center class=nospacing>';
            foreach ($this->data as $name => $value) {
                for ($i = 0; $i < floor($value/$totalSize*$this->sizeX); $i += $sX[$name]) {
                    $this->imageHTML .= '<img src="images/'.$this->image[$name].'" alt="'.$name.'" />';
                }
            }
            $this->imageHTML .= '</td></tr></table>';
        }
        
		function GraphLine($mFlags, $mFileName) {
			/* This is going to be f'ugly */
		}
		
        function GraphPie($mFlags,$mFileName) {
            foreach ($this->color as $objName => $colorValue)
                $this->color[$objName] = imagecolorallocate($this->canvas,$colorValue["red"],$colorValue["green"],$colorValue["blue"]);
            if (($mFlags & 'OPTION_ANTIALIASED') == 'OPTION_ANTIALIASED') {
                $this->canvas = imagecreatetruecolor(floor($this->sizeX*$this->aaFactor),floor($this->sizeY*$this->aaFactor));
                $resizedCanvas = imagecreatetruecolor($this->sizeX,$this->sizeY);
                imagefill($resizedCanvas,$this->sizeX,$this->sizeY,$this->color['background']);
                $x1 = ceil($this->sizeX / 2 * $this->aaFactor);
                $y1 = ceil($this->sizeY / 2 * $this->aaFactor);
                $radius = ($this->sizeX > $this->sizeY) ?
                                                         $this->sizeY * $this->aaFactor :
                                                         $this->sizeX * $this->aaFactor; 
            } else {
                $x1 = $this->sizeX / 2;            
                $y1 = $this->sizeY / 2;
                // fixes condition where user selects GRAPH_PIE
                // with unequal dimensions
                $radius = ($this->sizeX > $this->sizeY) ? $this->sizeY : $this->sizeX;
            }
            imagefill($this->canvas,$this->sizeX,$this->sizeY,$this->color['background']);
            
            $totalSize = array_sum($this->data);
            $radialOffset = 0;
    
            foreach ($this->data as $objName => $objValue) {
                if (!array_key_exists($objName,$this->color)) {
                    //ErrorLog::RaiseWarning("No color allocated for object '".$objName."', skipping");
                    continue;
                }
                imagefilledarc($this->canvas,
                               $x1,
                               $y1,
                               $radius,
                               $radius,
                               $radialOffset,
                               floor($objValue/$totalSize*360+$radialOffset),
                               $this->color[$objName],
                               IMG_ARC_PIE|IMG_ARC_EDGED
                );
                $radialOffset += ceil($this->data[$objName]/$totalSize*360);
            }
            
            if (($mFlags & 'OPTION_OUTLINE') == 'OPTION_OUTLINE') {
                imagefilledarc($this->canvas,
                               $x1,
                               $y1,
                               $radius,
                               $radius,
                               0,
                               360,
                               $this->color['outline'],
                               IMG_ARC_PIE|IMG_ARC_NOFILL
                );
            }
            if (($mFlags & 'OPTION_ANTIALIASED') == 'OPTION_ANTIALIASED') {
                imagecopyresampled($resizedCanvas,
                                   $this->canvas,
                                   0,
                                   0,
                                   0,
                                   0,
                                   $this->sizeX,
                                   $this->sizeY,
                                   floor($this->sizeX*$this->aaFactor),
                                   floor($this->sizeY*$this->aaFactor)
                );
                imagedestroy($this->canvas);
                $this->DisplayImage($resizedCanvas,$mFileName);
            } else
                $this->DisplayImage($this->canvas,$mFileName);
        }
        
        function GraphPie3D($mFlags,$mFileName) {
            foreach ($this->color as $objName => $colorValue)
                $this->color[$objName] = imagecolorallocate($this->canvas,$colorValue["red"],$colorValue["green"],$colorValue["blue"]);
            if (($mFlags & 'OPTION_ANTIALIASED') == 'OPTION_ANTIALIASED') {
                $this->canvas = imagecreatetruecolor(floor($this->sizeX*$this->aaFactor),floor($this->sizeY*$this->aaFactor));
                $resizedCanvas = imagecreatetruecolor($this->sizeX,$this->sizeY);
                imagefill($resizedCanvas,$this->sizeX,$this->sizeY,$this->color['background']);
                $x1 = ceil($this->sizeX / 2 * $this->aaFactor);            
                $y1 = ceil(($this->sizeY / 2) * $this->aaFactor) - 8;
                $radius = $this->sizeX * $this->aaFactor; 
            } else {
                $x1 = $this->sizeX / 2;            
                $y1 = $this->sizeY / 2 - 6;
                $radius = $this->sizeX;
            }
            imagefill($this->canvas,$this->sizeX,$this->sizeY,$this->color['background']);
            
            $totalSize = array_sum($this->data);
            $radialOffset = 0;

            imagefilledarc($this->canvas,
                           $x1,
                           (($mFlags & 'OPTION_ANTIALIASED') == 'OPTION_ANTIALIASED') ? $y1+5*$this->aaFactor : $y1+5,
                           $radius,
                           $radius*.7,
                           0,
                           180,
                           $this->color['shadow'],
                           IMG_ARC_PIE|IMG_ARC_EDGED
            );
            if (($mFlags & 'OPTION_OUTLINE') == 'OPTION_OUTLINE' ) {
                imagefilledarc($this->canvas,
                               $x1,
                               (($mFlags & 'OPTION_ANTIALIASED') == 'OPTION_ANTIALIASED') ? $y1+14 : $y1+6,
                               $radius,
                               $radius*.7,
                               0,
                               180,
                               $this->color['outline'],
                               IMG_ARC_PIE|IMG_ARC_NOFILL
                );
            }
            
            foreach ($this->data as $objName => $objValue) {
                if (!array_key_exists($objName,$this->color)) {
                    //ErrorLog::RaiseWarning("No color allocated for object '".$objName."', skipping");
                    continue;
                }
                imagefilledarc($this->canvas,
                               $x1,
                               $y1,
                               $radius,
                               $radius*.7,
                               $radialOffset,
                               floor($objValue/$totalSize*360+$radialOffset),
                               $this->color[$objName],
                               IMG_ARC_PIE|IMG_ARC_EDGED
                );
                $radialOffset += ceil($objValue/$totalSize*360);
            }
            
            
            if (($mFlags & 'OPTION_OUTLINE') == 'OPTION_OUTLINE') {
                imagefilledarc($this->canvas,
                               $x1,
                               $y1,
                               $radius,
                               $radius*.7,
                               0,
                               360,
                               $this->color['outline'],
                               IMG_ARC_PIE|IMG_ARC_NOFILL
                );
            }
            if (($mFlags & 'OPTION_ANTIALIASED') == 'OPTION_ANTIALIASED') {
                imagecopyresampled($resizedCanvas,
                                   $this->canvas,
                                   0,
                                   0,
                                   0,
                                   0,
                                   $this->sizeX,
                                   $this->sizeY,
                                   floor($this->sizeX*$this->aaFactor),
                                   floor($this->sizeY*$this->aaFactor)
                );
                imagedestroy($this->canvas);
                $this->DisplayImage($resizedCanvas,$mFileName);
            } else
                $this->DisplayImage($this->canvas,$mFileName);
        }
        
        function AddData($mName, $mValue) {
//            if (array_key_exists($mName,$this->data))
                //ErrorLog::RaiseNotice("Data already exists for object name ".$mName);                
            $this->data[$mName] = $mValue;
        }
        
        function PrintData() {
            if (sizeof($this->data) == 0) {
                //ErrorLog::RaiseNotice("PrintData() called with no data added");
            }
            foreach ($this->data as $name => $value) {
                print("\$this->data['".$name."'] = ".$value."\n<BR />\n");
            }
        }
        
        function Clean() {
            $this->Graph($this->sizeX, $this->sizeY);
        }
        
        /* WARNING: VALUES != 3 MAY CAUSE DISTORTION */
        function SetAAFactor($number) {
            $this->aaFactor = $number;
        }
    }
    /*
    *  The following three are examples for each graph option, when
    *  using, please don't uncomment these lines - instead invoke
    *  in another file, e.g. config.php
    *  *IF* redrawing from an existing class, *be sure* to call Clean()
    *  before attempting another DrawGraph() call.
    */
    /* Pie Chart
    $myGraph = new Graph(150,150);
    $myGraph->SetColor("background",255,255,255);
    $myGraph->AddData("used", 40);
    $myGraph->AddData("free", 300);
    $myGraph->DrawGraph('GRAPH_PIE','OPTION_OUTLINE'|'OPTION_ANTIALIASED');
    */
    /* 3D Pie Chart
    // multiply by 7 for the skewed vertical arc
    // and add 10 to account for the offset (approximation) for the shadow
    $myGraph = new Graph(150,150*.7 + 10);
    $myGraph->SetColor("background",255,255,255);
    $myGraph->AddData("used", 40);
    $myGraph->AddData("free", 300);
    $myGraph->DrawGraph('GRAPH_PIE_3D','OPTION_OUTLINE'|'OPTION_ANTIALIASED');
    */
    /* Discrete
    $myGraph = new Graph(150,16);
    $myGraph->AddData("used",50);
    $myGraph->AddData("free",100);
    $myGraph->SetColor("outline",140,140,140);
    $myGraph->SetColor("background",255,255,255);
    $myGraph->SetImage("free","images/dfree.gif");
    $myGraph->SetImage("used","images/dused.gif");
    $myGraph->DrawGraph('GRAPH_DISCRETE','OPTION_OUTLINE');
    */
    /* Continuous
    $myGraph = new Graph(150,12);
    $myGraph->AddData("used",50);
    $myGraph->AddData("free",100);
    $myGraph->SetColor("outline",140,140,140);
    $myGraph->SetColor("background",255,255,255);
    $myGraph->SetImage("free","images/cfree.gif");
    $myGraph->SetImage("used","images/cused.gif");
    $myGraph->DrawGraph('GRAPH_CONTINUOUS','OPTION_OUTLINE');
    */
    //3D Pie Chart, multiple values test:
	/*
    $myGraph = new Graph(120,120*.7 + 10);
    $myGraph->SetColor("background",255,255,255);
    $myGraph->AddData("used", 8000);
    $myGraph->AddData("free", 5000);
    $myGraph->AddData("tool", 3980);
    $myGraph->AddData("futz", 2130);
    $myGraph->SetColor("tool",0,210,50);
    $myGraph->SetColor("futz",210,0,50);
    $myGraph->DrawGraph('GRAPH_PIE_3D',
                        'OPTION_OUTLINE'|'OPTION_ANTIALIASED'
    );
  	*/
	/*$myGraph = new Graph(300,100);
    $myGraph->SetColor("background",255,255,255);
    $myGraph->AddData("total", 8000);
    $myGraph->AddData("in", array(*/
								//array(1088730180 /*2003-07-01*/,
								//      1091408580 /*2003-08-01*/)
								//=> 52649,
								//array(1091408580 /*2003-08-01*/,
								//      1094086980 /*2003-09-01*/)
								//=> 61115494,
								//array(1075683840 /*2004-02-01*/,
								//      1078189440 /*2004-03-01*/)
								//=> 24194));
    //$myGraph->AddData("out", array(
								//array(1088730180 /*2003-07-01*/,
								//      1091408580 /*2003-08-01*/)
								//=> 86074642939,
								//array(1091408580 /*2003-08-01*/,
								//      1094086980 /*2003-09-01*/)
								//=> 7544038686,
								//array(1075683840 /*2004-02-01*/,
								//      1078189440 /*2004-03-01*/)
								//=> 52637));
    /*$myGraph->DrawGraph('GRAPH_CHART',
                        'OPTION_OUTLINE'|'OPTION_ANTIALIASED'
    );*/
?>

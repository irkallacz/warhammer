<?php


// ******************************************************************************
// Software: mPDF, Unicode-HTML Free PDF generator                              *
// Version:  5.0     based on                                                   *
//           FPDF by Olivier PLATHEY                                            *
//           HTML2FPDF by Renato Coelho                                         *
// Date:     2010-09-19                                                         *
// Author:   Ian Back <ianb@bpm1.com>                                           *
// License:  GPL                                                                *
//                                                                              *
// Changes:  See changelog.txt                                                  *
// ******************************************************************************


define('mPDF_VERSION','5.0');

define('AUTOFONT_CJK',1);
define('AUTOFONT_THAIVIET',2);
define('AUTOFONT_RTL',4);
define('AUTOFONT_INDIC',8);
define('AUTOFONT_ALL',15);

define('_BORDER_ALL',15);
define('_BORDER_TOP',8);
define('_BORDER_RIGHT',4);
define('_BORDER_BOTTOM',2);
define('_BORDER_LEFT',1);

if (!defined('_MPDF_PATH')) define('_MPDF_PATH', dirname(preg_replace('/\\\\/','/',__FILE__)) . '/');
if (!defined('_MPDF_URI')) define('_MPDF_URI',_MPDF_PATH);	// mPDF 5.0

require_once(_MPDF_PATH.'includes/functions.php');
require_once(_MPDF_PATH.'config_cp.php');

if (!defined('_JPGRAPH_PATH')) define("_JPGRAPH_PATH", _MPDF_PATH.'jpgraph/'); 

if (!defined('_MPDF_TEMP_PATH')) define("_MPDF_TEMP_PATH", _MPDF_PATH.'tmp/');

if (!defined('_MPDF_TTFONTPATH')) { define('_MPDF_TTFONTPATH',_MPDF_PATH.'ttfonts/'); }	// mPDF 5.0
if (!defined('_MPDF_TTFONTDATAPATH')) { define('_MPDF_TTFONTDATAPATH',_MPDF_PATH.'ttfontdata/'); }

$errorlevel=error_reporting();
$errorlevel=error_reporting($errorlevel & ~E_NOTICE);

//error_reporting(E_ALL);

if(function_exists("date_default_timezone_set") and function_exists("date_default_timezone_get"))
@date_default_timezone_set(@date_default_timezone_get());
if (!function_exists("mb_strlen")) { die("Error - mPDF requires mb_string functions. Ensure that PHP is compiled with php_mbstring.dll enabled."); }

// mPDF 5.0
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}


class mPDF
{

///////////////////////////////
// EXTERNAL (PUBLIC) VARIABLES
// Define these in config.php
///////////////////////////////
// mPDF 5.0
var $iterationCounter;
var $smCapsScale;
var $smCapsStretch;

var $backupSubsFont;
var $backupSIPFont;
var $debugfonts;
var $useAdobeCJK;
var $percentSubset;
var $maxTTFFilesize;
var $BMPonly;

var $tableMinSizePriority;

var $dpi;
var $watermarkImgAlphaBlend;
var $watermarkImgBehind;
var $justifyB4br;
var $packTableData;
var $pgsIns;var $PDFA;var $PDFAauto;var $ICCProfile;var $simpleTables;
var $enableImports;

var $debug;
var $showStats;
var $setAutoTopMargin;
var $setAutoBottomMargin;
var $autoMarginPadding;
var $collapseBlockMargins;
var $falseBoldWeight;
var $normalLineheight;
var $progressBar;
var $incrementFPR1;
var $incrementFPR2;
var $incrementFPR3;
var $incrementFPR4;

var $hyphenate;
var $hyphenateTables;
var $SHYlang;
var $SHYleftmin;
var $SHYrightmin;
var $SHYcharmin;
var $SHYcharmax;
var $SHYlanguages;
// PageNumber Conditional Text
var $pagenumPrefix;
var $pagenumSuffix;
var $nbpgPrefix;
var $nbpgSuffix;
var $showImageErrors;
var $allow_output_buffering;
var $autoPadding;
var $useGraphs;
var $autoFontGroupSize;
var $disableMultilingualJustify;
var $tabSpaces;
var $useLang;
var $restoreBlockPagebreaks;
var $watermarkTextAlpha;
var $watermarkImageAlpha;
var $watermark_size;
var $watermark_pos;
var $annotSize;
var $annotMargin;
var $annotOpacity;
var $title2annots;
var $keepColumns;
var $keep_table_proportions;
var $ignore_table_widths;
var $ignore_table_percents;
var $list_align_style;
var $list_number_suffix;
var $useSubstitutions;
var $CSSselectMedia;
// $disablePrintCSS depracated

var $forcePortraitHeaders;
var $forcePortraitMargins;
var $displayDefaultOrientation;
var $ignore_invalid_utf8;
var $allowedCSStags;
var $onlyCoreFonts;
var $allow_charset_conversion;

var $jSpacing;
var $jSWord;
var $jSmaxChar;
var $jSmaxCharLast;
var $jSmaxWordLast;

var $orphansAllowed;
var $max_colH_correction;


var $table_error_report;
var $table_error_report_param;
var $biDirectional;
var $text_input_as_HTML; 
var $anchor2Bookmark;
var $list_indent_first_level;
var $shrink_tables_to_fit;

var $rtlCSS;

var $allow_html_optional_endtags;

var $img_dpi;

var $defaultheaderfontsize;
var $defaultheaderfontstyle;
var $defaultheaderline;
var $defaultfooterfontsize;
var $defaultfooterfontstyle;
var $defaultfooterline;
var $header_line_spacing;
var $footer_line_spacing;

var $textarea_lineheight;

var $pregRTLchars;
var $pregUHCchars;
var $pregSJISchars;
var $pregCJKchars;
var $pregASCIIchars1;
var $pregASCIIchars2;
var $pregASCIIchars3;
var $pregVIETchars;
var $pregVIETPluschars;
var $pregHEBchars;
var $pregARABICchars;
var $pregNonARABICchars;
// INDIC
var $pregHIchars;
var $pregBNchars;
var $pregPAchars;
var $pregGUchars;
var $pregORchars;
var $pregTAchars;
var $pregTEchars;
var $pregKNchars;
var $pregMLchars;
var $pregSHchars;
var $pregINDextra;

var $mirrorMargins;
var $default_lineheight_correction;
var $watermarkText;
var $watermarkImage;
var $showWatermarkText;
var $showWatermarkImage;

var $fontsizes;

// Aliases for backward compatability
var $UnvalidatedText;	// alias = $watermarkText
var $TopicIsUnvalidated;	// alias = $showWatermarkText
var $useOddEven;		// alias = $mirrorMargins
var $useSubstitutionsMB;	// alias = $useSubstitutions


//////////////////////
// INTERNAL VARIABLES
//////////////////////
var $inlineDisplayOff;	// mPDF 5.0
var $kt_y00;
var $kt_p00;
var $upperCase;
var $checkSIP;	// mPDF 5.0
var $checkSMP;	// mPDF 5.0.03
var $checkCJK;	// mPDF 5.0
var $tableCJK;	// mPDF 5.0

var $watermarkImgAlpha;
var $PDFAwarnings;
var $MetadataRoot; 
var $OutputIntentRoot;
var $InfoRoot; 
var $current_filename;
var $parsers;
var $current_parser;
var $_obj_stack;
var $_don_obj_stack;
var $_current_obj_id;
var $tpls;
var $tpl;
var $tplprefix;
var $_res;

var $pdf_version;
var $noImageFile;
var $lastblockbottommargin;
var $baselineC;
var $subPos;
var $subArrMB;
var $ReqFontStyle;
var $tableClipPath ;
var $forceExactLineheight;
var $listOcc; 

var $fullImageHeight;
var $inFixedPosBlock;		// Internal flag for position:fixed block
var $fixedPosBlock;		// Buffer string for position:fixed block
var $fixedPosBlockDepth;
var $fixedPosBlockBBox;
var $fixedPosBlockSave;
var $maxPosL;
var $maxPosR;

var $loaded;

var $extraFontSubsets;
var $docTemplateStart;		// Internal flag for page (page no. -1) that docTemplate starts on
var $time0;

// Classes
var $indic;
var $barcode;

var $SHYpatterns;
var $loadedSHYpatterns;
var $loadedSHYdictionary;
var $SHYdictionary;
var $SHYdictionaryWords;

var $spanbgcolorarray;
var $default_font;
var $list_lineheight;
var $headerbuffer;
var $lastblocklevelchange;
var $nestedtablejustfinished;
var $linebreakjustfinished;
var $cell_border_dominance_L;
var $cell_border_dominance_R;
var $cell_border_dominance_T;
var $cell_border_dominance_B;
var $tbCSSlvl;
var $listCSSlvl;
var $table_keep_together;
var $plainCell_properties;
var $inherit_lineheight;
var $listitemtype;
var $shrin_k1;
var $outerfilled;

var $blockContext;
var $floatDivs;

var $tablecascadeCSS;
var $listcascadeCSS;

var $patterns;
var $pageBackgrounds;

var $bodyBackgroundGradient;
var $bodyBackgroundImage;
var $bodyBackgroundColor;

var $writingHTMLheader;	// internal flag - used both for writing HTMLHeaders/Footers and FixedPos block
var $writingHTMLfooter;
var $autoFontGroups;
var $angle;

var $gradients;

var $kwt_Reference;
var $kwt_BMoutlines;
var $kwt_toc;

var $tbrot_Reference;
var $tbrot_BMoutlines;
var $tbrot_toc;

var $col_Reference;
var $col_BMoutlines;
var $col_toc;

var $currentGraphId;
var $graphs;

var $floatbuffer;
var $floatmargins;

var $bullet;
var $bulletarray;

var $rtlAsArabicFarsi;		// DEPRACATED

var $currentLang;
var $default_lang;
var $default_jSpacing;
var $default_available_fonts;
var $default_dir;

var $pageTemplate;
var $docTemplate;
var $docTemplateContinue;

var $arabGlyphs;
var $arabHex;
var $persianGlyphs;
var $persianHex;
var $arabVowels;
var $arabPrevLink;
var $arabNextLink;


var $formobjects; // array of Form Objects for WMF
var $gdiObjectArray;      // array of GDI objects for WMF
var $InlineProperties;	// Should have done this a long time ago
var $InlineAnnots;
var $ktAnnots;
var $tbrot_Annots;
var $kwt_Annots;
var $columnAnnots;

var $PageAnnots;

var $pageDim;	// Keep track of page wxh for orientation changes - set in _beginpage, used in _putannots

var $breakpoints;


var $tableLevel;
var $tbctr;
var $innermostTableLevel;
var $saveTableCounter;
var $cellBorderBuffer;

var $saveHTMLFooter_height;
var $saveHTMLFooterE_height;

var $firstPageBoxHeader;
var $firstPageBoxHeaderEven;
var $firstPageBoxFooter;
var $firstPageBoxFooterEven;

var $page_box;
var $show_marks;	// crop or cross marks

var $basepathIsLocal;

var $use_kwt;
var $kwt;
var $kwt_height;
var $kwt_y0;
var $kwt_x0;
var $kwt_buffer;
var $kwt_Links;
var $kwt_moved;
var $kwt_saved;

// NOT USED???
var $formBgColor;
var $formBgColorSmall;	// Color used for background of form fields if reduced in size (so border disappears)

var $PageNumSubstitutions;

 
var $table_borders_separate;
var $base_table_properties;
var $borderstyles;
// doesn't include none or hidden

var $listjustfinished;
var $blockjustfinished;

var $orig_bMargin;
var $orig_tMargin;
var $orig_lMargin;
var $orig_rMargin;
var $orig_hMargin;
var $orig_fMargin;

var $pageheaders;
var $pagefooters;

var $pageHTMLheaders;
var $pageHTMLfooters;

var $saveHTMLHeader;
var $saveHTMLFooter;

var $HTMLheaderPageLinks;
var $HTMLheaderPageAnnots;	// mPDF 5.0

// See config_fonts.php for these next 5 values
var $available_unifonts;
var $sans_fonts;
var $serif_fonts;
var $mono_fonts;
var $defaultSubsFont;	// mPDF 5.0

// List of ALL available CJK fonts (incl. styles) (Adobe add-ons)  hw removed
var $available_CJK_fonts;

var $cascadeCSS;

var $HTMLHeader;
var $HTMLFooter;
var $HTMLHeaderE;	// for Even pages
var $HTMLFooterE;	// for Even pages
var $bufferoutput; 



var $showdefaultpagenos;	// DEPRACATED -left for backward compatability


var $chrs;
var $ords;

// CJK fonts
var $Big5_widths;
var $GB_widths;
var $SJIS_widths;
var $UHC_widths;

// SetProtection
var $encrypted;    //whether document is protected
var $Uvalue;             //U entry in pdf document
var $Ovalue;             //O entry in pdf document
var $Pvalue;             //P entry in pdf document
var $enc_obj_id;         //encryption object id
var $last_rc4_key;       //last RC4 key encrypted (cached for optimisation)
var $last_rc4_key_c;     //last RC4 computed key
var $encryption_key;
var $padding;		//used for encryption

// Bookmark
var $BMoutlines;
var $OutlineRoot;
// TOC
var $_toc;
var $TOCmark;
var $TOCfont;
var $TOCfontsize;
var $TOCindent;
var $TOCheader;
var $TOCfooter;
var $TOCpreHTML;
var $TOCpostHTML;
var $TOCbookmarkText;
var $TOCusePaging;
var $TOCuseLinking;
var $TOCorientation;
var $TOC_margin_left;
var $TOC_margin_right;
var $TOC_margin_top;
var $TOC_margin_bottom;
var $TOC_margin_header;
var $TOC_margin_footer;
var $TOC_odd_header_name;
var $TOC_even_header_name;
var $TOC_odd_footer_name;
var $TOC_even_footer_name;
var $TOC_odd_header_value;
var $TOC_even_header_value;
var $TOC_odd_footer_value;
var $TOC_even_footer_value;
var $TOC_start;
var $TOC_end;
var $TOC_npages;
var $m_TOC; 
// INDEX
var $ColActive;
var $ChangePage;		//Flag indicating that a page break has occurred
var $Reference;
var $CurrCol;
var $NbCol;
var $y0;			//Top ordinate of columns
var $ColL;
var $ColWidth;
var $ColGap;
// COLUMNS 
var $ColR;
var $ChangeColumn;
var $columnbuffer;
var $ColDetails;
var $columnLinks;
var $colvAlign;
// Substitutions
var $substitute;		// Array of substitution strings e.g. <ttz>112</ttz>
var $entsearch;		// Array of HTML entities (>ASCII 127) to substitute
var $entsubstitute;	// Array of substitution decimal unicode for the Hi entities


// Default values if no style sheet offered	(cf. http://www.w3.org/TR/CSS21/sample.html)
var $defaultCSS;

var $form_element_spacing;
var $linemaxfontsize;
var $lineheight_correction;
var $lastoptionaltag;	// Save current block item which HTML specifies optionsl endtag
var $pageoutput;
var $charset_in;
var $blk;
var $blklvl;
var $ColumnAdjust;
var $ws;	// Word spacing
var $HREF;
var $pgwidth;
var $fontlist; 
var $issetfont;
var $issetcolor;
var $oldx;
var $oldy;
var $B;
var $U;      //underlining flag
var $S;	// mPDF 5.0 SmallCaps flag
var $I;

var $tdbegin;
var $table;
var $cell;
var $col;
var $row;

var $divbegin;
var $divalign;
var $divwidth;
var $divheight;
var $divrevert;
var $spanbgcolor;

var $spanlvl;
var $listlvl;
var $listnum;
var $listtype;
var $listoccur;
var $listlist;
var $listitem;

var $pjustfinished;
var $ignorefollowingspaces;
var $SUP;
var $SUB;
var $SMALL;
var $BIG;
var $toupper;
var $tolower;
var $dash_on;
var $dotted_on;
var $strike;

var $CSS;
var $textbuffer;
var $currentfontstyle;
var $currentfontfamily;
var $currentfontsize;
var $colorarray;
var $bgcolorarray;
var $internallink;
var $enabledtags;

var $lineheight;
var $basepath;
var $outlineparam;
var $outline_on;

var $specialcontent;
var $selectoption;

var $usecss;
var $usepre;
var $usetableheader;

var $tableheadernrows;
var $tablefooternrows;

var $objectbuffer;

// Table Rotation
var $table_rotate;
var $tbrot_maxw;
var $tbrot_maxh;
var $tablebuffer;
var $tbrot_align;
var $tbrot_Links;

var $divbuffer;		// Buffer used when keeping DIV on one page
var $keep_block_together;	// Keep a Block from page-break-inside: avoid
var $ktLinks;		// Keep-together Block links array
var $ktBlock;		// Keep-together Block array
var $ktReference;
var $ktBMoutlines;
var $_kttoc;

var $tbrot_y0;
var $tbrot_x0;
var $tbrot_w;
var $tbrot_h;

var $mb_enc;
var $directionality;

var $extgstates; // Used for alpha channel - Transparency (Watermark)
var $tt_savefont;
var $mgl;
var $mgt;
var $mgr;
var $mgb;

var $tts;
var $ttz;
var $tta;

var $headerDetails;
var $footerDetails;

// Best to alter the below variables using default stylesheet above
var $div_margin_bottom;
var $div_bottom_border;
var $p_margin_bottom;
var $p_bottom_border;
var $page_break_after_avoid;
var $margin_bottom_collapse;
var $img_margin_top;	// default is set at top of fn.openTag 'IMG'
var $img_margin_bottom;
var $list_indent;
var $list_align;
var $list_margin_bottom; 
var $default_font_size;	// in pts
var $original_default_font_size;	// used to save default sizes when using table default
var $original_default_font;
var $watermark_font;
var $defaultAlign;

// TABLE
var $defaultTableAlign;
var $tablethead;
var $thead_font_weight;
var $thead_font_style;
var $thead_font_smCaps;	// mPDF 5.0
var $thead_valign_default;
var $thead_textalign_default;
var $tabletfoot;
var $tfoot_font_weight;
var $tfoot_font_style;
var $tfoot_font_smCaps;	// mPDF 5.0
var $tfoot_valign_default;
var $tfoot_textalign_default;

var $trow_text_rotate;

var $cellPaddingL;
var $cellPaddingR;
var $cellPaddingT;
var $cellPaddingB;
var $table_lineheight;
var $table_border_attr_set;
var $table_border_css_set;

var $shrin_k;			// factor with which to shrink tables - used internally - do not change
var $shrink_this_table_to_fit;	// 0 or false to disable; value (if set) gives maximum factor to reduce fontsize
var $MarginCorrection;	// corrects for OddEven Margins
var $margin_footer;
var $margin_header;

var $tabletheadjustfinished;
var $usingCoreFont;
var $charspacing;

//Private properties FROM FPDF
var $DisplayPreferences; 
var $outlines;
var $flowingBlockAttr;
var $page;               //current page number
var $n;                  //current object number
var $offsets;            //array of object offsets
var $buffer;             //buffer holding in-memory PDF
var $pages;              //array containing pages
var $state;              //current document state
var $compress;           //compression flag
var $DefOrientation;     //default orientation
var $CurOrientation;     //current orientation
var $OrientationChanges; //array indicating orientation changes
var $k;                  //scale factor (number of points in user unit)
var $fwPt;
var $fhPt;         //dimensions of page format in points
var $fw;
var $fh;             //dimensions of page format in user unit
var $wPt;
var $hPt;           //current dimensions of page in points
var $w;
var $h;               //current dimensions of page in user unit
var $lMargin;            //left margin
var $tMargin;            //top margin
var $rMargin;            //right margin
var $bMargin;            //page break margin
var $cMarginL;            //cell margin Left
var $cMarginR;            //cell margin Right
var $cMarginT;            //cell margin Left
var $cMarginB;            //cell margin Right
var $DeflMargin;            //Default left margin
var $DefrMargin;            //Default right margin
var $x;
var $y;               //current position in user unit for cell positioning
var $lasth;              //height of last cell printed
var $LineWidth;          //line width in user unit
var $CoreFonts;          //array of standard font names
var $fonts;              //array of used fonts
var $FontFiles;          //array of font files
var $diffs;              //array of encoding differences
var $images;             //array of used images
var $PageLinks;          //array of links in pages
var $links;              //array of internal links
var $FontFamily;         //current font family
var $FontStyle;          //current font style
var $CurrentFont;        //current font info
var $FontSizePt;         //current font size in points
var $FontSize;           //current font size in user unit
var $DrawColor;          //commands for drawing color
var $FillColor;          //commands for filling color
var $TextColor;          //commands for text color
var $ColorFlag;          //indicates whether fill and text colors are different
var $autoPageBreak;      //automatic page breaking
var $PageBreakTrigger;   //threshold used to trigger page breaks
var $InFooter;           //flag set when processing footer
var $InHTMLFooter;

var $processingFooter;   //flag set when processing footer - added for columns
var $processingHeader;   //flag set when processing header - added for columns
var $ZoomMode;           //zoom display mode
var $LayoutMode;         //layout display mode
var $title;              //title
var $subject;            //subject
var $author;             //author
var $keywords;           //keywords
var $creator;            //creator

var $aliasNbPg;       //alias for total number of pages
var $aliasNbPgGp;       //alias for total number of pages in page group
var $aliasNbPgHex;       // mPDF 5.0.04
var $aliasNbPgGpHex;       // mPDF 5.0.04

var $ispre;

var $outerblocktags;
var $innerblocktags;
// NOT Currently used
var $inlinetags;
var $listtags;
var $tabletags;
var $formtags;


// **********************************
// **********************************
// **********************************
// **********************************
// **********************************
// **********************************
// **********************************
// **********************************
// **********************************

function mPDF($mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P') {

	$this->time0 = microtime(true);
	$unit='mm';
	//Some checks
	$this->_dochecks();

	// Set up Aliases for backwards compatability
	$this->UnvalidatedText =& $this->watermarkText;
	$this->TopicIsUnvalidated =& $this->showWatermarkText;
	$this->AliasNbPg =& $this->aliasNbPg;
	$this->AliasNbPgGp =& $this->aliasNbPgGp;
	$this->BiDirectional =& $this->biDirectional;
	$this->Anchor2Bookmark =& $this->anchor2Bookmark;
	$this->KeepColumns =& $this->keepColumns;
	$this->useOddEven =& $this->mirrorMargins;
	$this->useSubstitutionsMB =& $this->useSubstitutions;	// mPDF 5.0


	//Initialization of properties
	// mPDF 5.0
	$this->kt_y00 = '';
	$this->kt_p00 = '';
	$this->iterationCounter = false;
	$this->BMPonly = array();
	$this->page=0;
	$this->n=2;
	$this->buffer='';
	$this->objectbuffer = array();
	$this->pages=array();
	$this->OrientationChanges=array();
	$this->state=0;
	$this->fonts=array();
	$this->FontFiles=array();
	$this->diffs=array();
	$this->images=array();
	$this->links=array();
	$this->InFooter=false;
	$this->processingFooter=false;
	$this->processingHeader=false;
	$this->lasth=0;
	$this->FontFamily='';
	$this->FontStyle='';
	$this->FontSizePt=9;
	$this->U=false;
	// mPDF 5.0 Small Caps
	$this->upperCase = array();
	@include(_MPDF_PATH.'includes/upperCase.php');
	$this->S = false;	// mPDF 5.0
	$this->smCapsScale = 1;
	$this->smCapsStretch = 100;
	$this->DrawColor='0 G';
	$this->FillColor='0 g';
	$this->TextColor='0 g';
	$this->ColorFlag=false;
	$this->extgstates = array();

	$this->mb_enc='windows-1252';
	$this->directionality='ltr';
	$this->defaultAlign = 'L';
	$this->defaultTableAlign = 'L';

	$this->fixedPosBlockSave = array();
	$this->extraFontSubsets = 0;

	$this->SHYpatterns = array();
	$this->loadedSHYdictionary = false;
	$this->SHYdictionary = array();
	$this->SHYdictionaryWords = array();
	$this->blockContext = 1;
	$this->floatDivs = array();
	$this->DisplayPreferences=''; 

	$this->tablecascadeCSS = array();
	$this->listcascadeCSS = array();

	$this->patterns = array();		// Tiling patterns used for backgrounds
	$this->pageBackgrounds = array();
	$this->writingHTMLheader = false;	// internal flag - used both for writing HTMLHeaders/Footers and FixedPos block
	$this->writingHTMLfooter = false;	// internal flag - used both for writing HTMLHeaders/Footers and FixedPos block
	$this->gradients = array();

	$this->kwt_Reference = array();
	$this->kwt_BMoutlines = array();
	$this->kwt_toc = array();

	$this->tbrot_Reference = array();
	$this->tbrot_BMoutlines = array();
	$this->tbrot_toc = array();

	$this->col_Reference = array();
	$this->col_BMoutlines = array();
	$this->col_toc = array();
	$this->graphs = array();

	$this->pgsIns = array();
	$this->PDFAwarnings = array();
	$this->inlineDisplayOff = false;	// mPDF 5.0


	$this->baselineC = 0.35;	// Baseline for text
	$this->noImageFile = str_replace("\\","/",dirname(__FILE__)) . '/includes/no_image.jpg';
	$this->subPos = 0;
	$this->forceExactLineheight = false;
	$this->listOcc = 0;
	$this->normalLineheight = 1.3;
	// These are intended as configuration variables, and should be set in config.php - which will override these values; 
	// set here as failsafe as will cause an error if not defined
	$this->incrementFPR1 = 10;
	$this->incrementFPR2 = 10;
	$this->incrementFPR3 = 10;
	$this->incrementFPR4 = 10;

	$this->fullImageHeight = false;
	$this->floatbuffer = array();
	$this->floatmargins = array();
	$this->autoFontGroups = 0;
	$this->formobjects=array(); // array of Form Objects for WMF
	$this->InlineProperties=array();
	$this->InlineAnnots=array();
	$this->ktAnnots=array();
	$this->tbrot_Annots=array();
	$this->kwt_Annots=array();
	$this->columnAnnots=array();
	$this->pageDim=array();
	$this->breakpoints = array();	// used in columnbuffer
	$this->tableLevel=0;
	$this->tbctr=array();	// counter for nested tables at each level
	$this->page_box = array();
	$this->show_marks = '';	// crop or cross marks
	$this->kwt = false;
	$this->kwt_height = 0;
	$this->kwt_y0 = 0;
	$this->kwt_x0 = 0;
	$this->kwt_buffer = array();
	$this->kwt_Links = array();
	$this->kwt_moved = false;
	$this->kwt_saved = false;
	$this->PageNumSubstitutions = array();
	$this->base_table_properties=array();
	$this->borderstyles = array('inset','groove','outset','ridge','dotted','dashed','solid','double');
	$this->tbrot_align = 'C';
	$this->pageheaders=array();
	$this->pagefooters=array();

	$this->pageHTMLheaders=array();
	$this->pageHTMLfooters=array();
	$this->HTMLheaderPageLinks = array();
	$this->HTMLheaderPageAnnots = array();	// mPDF 5.0

	$this->cascadeCSS = array();
	$this->bufferoutput = false; 
	$this->encrypted=false;    		//whether document is protected
	$this->BMoutlines=array();
	$this->_toc=array();
	$this->TOCheader=false;
	$this->TOCfooter=false;
	$this->ColActive=0;        		//Flag indicating that columns are on (the index is being processed)
	$this->ChangePage=0;       		//Flag indicating that a page break has occurred
	$this->Reference=array();  		//Array containing the references
	$this->CurrCol=0;              	//Current column number
	$this->ColL = array(0);			// Array of Left pos of columns - absolute - needs Margin correction for Odd-Even
	$this->ColR = array(0);			// Array of Right pos of columns - absolute pos - needs Margin correction for Odd-Even
	$this->ChangeColumn = 0;
	$this->columnbuffer = array();
	$this->ColDetails = array();		// Keeps track of some column details
	$this->columnLinks = array();		// Cross references PageLinks
	$this->substitute = array();		// Array of substitution strings e.g. <ttz>112</ttz>
	$this->entsearch = array();		// Array of HTML entities (>ASCII 127) to substitute
	$this->entsubstitute = array();	// Array of substitution decimal unicode for the Hi entities
	$this->lastoptionaltag = '';
	$this->charset_in = '';
	$this->blk = array();
	$this->blklvl = 0;
	$this->TOCmark = 0;
	$this->tts = false;
	$this->ttz = false;
	$this->tta = false;
	$this->ispre=false;

	$this->checkSIP = false; 	// mPDF 5.0
	$this->checkSMP = false; 	// mPDF 5.0.03
	$this->checkCJK = false; 	// mPDF 5.0
	$this->tableCJK = false; 	// mPDF 5.0

	$this->headerDetails=array();
	$this->footerDetails=array();
	$this->div_bottom_border = '';
	$this->p_bottom_border = '';
	$this->page_break_after_avoid = false;
	$this->margin_bottom_collapse = false;
	$this->tablethead = 0;
	$this->tabletfoot = 0;
	$this->table_border_attr_set = 0;
	$this->table_border_css_set = 0;
	$this->shrin_k = 1.0;
	$this->shrink_this_table_to_fit = 0;
	$this->MarginCorrection = 0;

	$this->tabletheadjustfinished = false;
	$this->usingCoreFont = false;
	$this->charspacing=0;

	$this->outlines=array();
	$this->autoPageBreak = true;


	require(_MPDF_PATH.'config.php');	// config data

	//Scale factor
	$this->k=72/25.4;	// Will only use mm

	$this->_setPageSize($format, $orientation);
	$this->DefOrientation=$orientation;

	$this->margin_header=$mgh;
	$this->margin_footer=$mgf;

	$bmargin=$mgb;

	$this->DeflMargin = $mgl;
	$this->DefrMargin = $mgr;

	// v1.4 Save orginal settings in case of changed orientation
	$this->orig_tMargin = $mgt;
	$this->orig_bMargin = $bmargin;
	$this->orig_lMargin = $this->DeflMargin;
	$this->orig_rMargin = $this->DefrMargin;
	$this->orig_hMargin = $this->margin_header;
	$this->orig_fMargin = $this->margin_footer;


	if ($this->setAutoTopMargin=='pad') { $mgt += $this->margin_header; }
	if ($this->setAutoBottomMargin=='pad') { $mgb += $this->margin_footer; }
	$this->SetMargins($this->DeflMargin,$this->DefrMargin,$mgt);	// sets l r t margin
	//Automatic page break
	$this->SetAutoPageBreak($this->autoPageBreak,$bmargin);	// sets $this->bMargin & PageBreakTrigger

	$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;

	//Interior cell margin (1 mm) ? not used
	$this->cMarginL = 1;
	$this->cMarginR = 1;
	//Line width (0.2 mm)
	$this->LineWidth=.567/$this->k;

	//To make the function Footer() work - replaces {nb} with page number
	$this->AliasNbPages();
	$this->AliasNbPageGroups();

	// mPDF 5.0.04
	$this->aliasNbPgHex = '{nbHEXmarker}';
	$this->aliasNbPgGpHex = '{nbpgHEXmarker}';


	//Enable all tags as default
	$this->DisableTags();
	//Full width display mode
	$this->SetDisplayMode(100);	// fullwidth?		'fullpage'
	//Compression
	$this->SetCompression(true);
	//Set default display preferences
	$this->SetDisplayPreferences(''); 


	// Font data
	require(_MPDF_PATH.'config_fonts.php');
	// Available fonts
	$this->available_unifonts = array();
	foreach ($this->fontdata AS $f => $fs) {
		if (isset($fs['R']) && $fs['R']) { $this->available_unifonts[] = $f; }
		if (isset($fs['B']) && $fs['B']) { $this->available_unifonts[] = $f.'B'; }
		if (isset($fs['I']) && $fs['I']) { $this->available_unifonts[] = $f.'I'; }
		if (isset($fs['BI']) && $fs['BI']) { $this->available_unifonts[] = $f.'BI'; }
	}

	$this->default_available_fonts = $this->available_unifonts;


	$optcore = false;
	$onlyCoreFonts = false;
	// mPDF 5.0
	if (preg_match('/([\-+])aCJK/i',$mode, $m)) {
		preg_replace('/([\-+])aCJK/i','',$mode);
		if ($m[1]=='+') { $this->useAdobeCJK = true; }
		else { $this->useAdobeCJK = false; }
	}

	if (strlen($mode)==1) {
		if ($mode=='s') { $this->percentSubset = 100; $mode = ''; }
		else if ($mode=='c') { $onlyCoreFonts = true; $mode = ''; }
	}
	else if (substr($mode,-2)=='-s') {
		$this->percentSubset = 100; 
		$mode = substr($mode,0,strlen($mode)-2);
	}
	else if (substr($mode,-2)=='-c') {
		$onlyCoreFonts = true;
		$mode = substr($mode,0,strlen($mode)-2);
	}
	else if (substr($mode,-2)=='-x') {
		$optcore = true;
		$mode = substr($mode,0,strlen($mode)-2);
	}

	// Autodetect if mode is a language_country string (en-GB or en_GB or en)
	if ((strlen($mode) == 5 && $mode != 'UTF-8') || strlen($mode) == 2) {
		list ($coreSuitable,$mpdf_pdf_unifonts,$mpdf_directionality,$mpdf_jSpacing) = GetLangOpts($mode, $this->useAdobeCJK);
		if ($coreSuitable && $optcore) { $onlyCoreFonts = true; }
		$this->jSpacing = $mpdf_jSpacing;
		if ($mpdf_pdf_unifonts) { 
			$this->RestrictUnicodeFonts($mpdf_pdf_unifonts); 
			$this->default_available_fonts = $mpdf_pdf_unifonts;
		}
		$this->SetDirectionality($mpdf_directionality);
		$this->currentLang = $mode;
		$this->default_lang = $mode;
		$this->default_jSpacing = $mpdf_jSpacing;
		$this->default_dir = $mpdf_directionality;
	}

	$this->onlyCoreFonts =  $onlyCoreFonts;

	if ($this->onlyCoreFonts) {
		$this->setMBencoding('windows-1252');	// sets $this->mb_enc
	}
	else {
		$this->setMBencoding('UTF-8');	// sets $this->mb_enc
	}
	@mb_regex_encoding('UTF-8'); 


	// mPDF 5.0 Adobe CJK fonts
	//if ($this->useAdobeCJK) {
		$this->available_CJK_fonts = array('gb','big5','sjis','uhc','gbB','big5B','sjisB','uhcB','gbI','big5I','sjisI','uhcI',
		'gbBI','big5BI','sjisBI','uhcBI');
	//}
	//else { $this->available_CJK_fonts = array(); }


	//Standard fonts
	$this->CoreFonts=array('ccourier'=>'Courier','ccourierB'=>'Courier-Bold','ccourierI'=>'Courier-Oblique','ccourierBI'=>'Courier-BoldOblique',
		'chelvetica'=>'Helvetica','chelveticaB'=>'Helvetica-Bold','chelveticaI'=>'Helvetica-Oblique','chelveticaBI'=>'Helvetica-BoldOblique',
		'ctimes'=>'Times-Roman','ctimesB'=>'Times-Bold','ctimesI'=>'Times-Italic','ctimesBI'=>'Times-BoldItalic',
		'csymbol'=>'Symbol','czapfdingbats'=>'ZapfDingbats');
	$this->fontlist=array("ctimes","ccourier","chelvetica","csymbol","czapfdingbats");

	// Substitutions
	$this->setHiEntitySubstitutions();

	if ($this->onlyCoreFonts) {
		$this->useSubstitutions = true;
		$this->SetSubstitutions();
	}
	else { $this->useSubstitutions = false; }

	if (file_exists(_MPDF_PATH.'mpdf.css')) {
		$css = file_get_contents(_MPDF_PATH.'mpdf.css');
		$css2 = $this->ReadDefaultCSS($css);
		$this->defaultCSS = $this->array_merge_recursive_unique($this->defaultCSS,$css2); 
	}

	if ($default_font=='') { 
	  if ($this->onlyCoreFonts) { 
		if (in_array(strtolower($this->defaultCSS['BODY']['FONT-FAMILY']),$this->mono_fonts)) { $default_font = 'ccourier'; }
		else if (in_array(strtolower($this->defaultCSS['BODY']['FONT-FAMILY']),$this->sans_fonts)) { $default_font = 'chelvetica'; }
		else { $default_font = 'ctimes'; }
	  }
	  else { $default_font = $this->defaultCSS['BODY']['FONT-FAMILY']; }
	}
	if (!$default_font_size) { 
		$mmsize = $this->ConvertSize($this->defaultCSS['BODY']['FONT-SIZE']);
		$default_font_size = $mmsize*($this->k);
	}

	if ($default_font) { $this->SetDefaultFont($default_font); }
	if ($default_font_size) { $this->SetDefaultFontSize($default_font_size); }

	$this->SetLineHeight();	// lineheight is in mm

	$this->SetFillColor(255);
	$this->HREF='';
	$this->oldy=-1;
	$this->B=0;
	$this->U=0;
	$this->S=0;	// mPDF 5.0
	$this->I=0;

	$this->listlvl=0;
	$this->listnum=0; 
	$this->listtype='';
	$this->listoccur=array();
	$this->listlist=array();
	$this->listitem=array();

	$this->tdbegin=false; 
	$this->table=array(); 
	$this->cell=array();  
	$this->col=-1; 
	$this->row=-1; 
	$this->cellBorderBuffer = array();

	$this->divbegin=false;
	$this->divalign=$this->defaultAlign;
	$this->divwidth=0; 
	$this->divheight=0; 
	$this->spanbgcolor=false;
	$this->divrevert=false;

	$this->issetfont=false;
	$this->issetcolor=false;

	$this->blockjustfinished=false;
	$this->listjustfinished=false;
	$this->ignorefollowingspaces = true; //in order to eliminate exceeding left-side spaces
	$this->toupper=false;
	$this->tolower=false;
	$this->dash_on=false;
	$this->dotted_on=false;
	$this->SUP=false;
	$this->SUB=false;
	$this->strike=false;

	$this->currentfontfamily='';
	$this->currentfontsize='';
	$this->currentfontstyle='';
	$this->colorarray=array();
	$this->spanbgcolorarray=array();
	$this->textbuffer=array();
	$this->CSS=array();
	$this->internallink=array();
	$this->basepath = "";

	$this->SetBasePath('');

	$this->outlineparam = array();
	$this->outline_on = false;

	$this->specialcontent = '';
	$this->selectoption = array();

	$this->usetableheader=false;
	$this->usecss=true;
	$this->usepre=true;

	for($i=0;$i<256;$i++) {
		$this->chrs[$i] = chr($i);
		$this->ords[chr($i)] = $i;

	}


	if ($this->progressBar) { $this->StartProgressBarOutput($this->progressBar) ;	}
}


function _setPageSize($format, &$orientation) {
	//Page format
	if(is_string($format))
	{
		if ($format=='') { $format = 'A4'; }
		$pfo = 'P';
		if(preg_match('/([0-9a-zA-Z]*)-L/i',$format,$m)) {	// e.g. A4-L = A$ landscape
			$format=$m[1]; 
			$pfo='L'; 
		}
		$format = $this->_getPageFormat($format);
		if (!$format) { $this->Error('Unknown page format: '.$format); }
		else { $orientation = $pfo; }

		$this->fwPt=$format[0];
		$this->fhPt=$format[1];
	}
	else
	{
		if (!$format[0] || !$format[1]) { $this->Error('Invalid page format: '.$format[0].' '.$format[1]); }
		$this->fwPt=$format[0]*$this->k;
		$this->fhPt=$format[1]*$this->k;
	}
	$this->fw=$this->fwPt/$this->k;
	$this->fh=$this->fhPt/$this->k;
	//Page orientation
	$orientation=strtolower($orientation);
	if($orientation=='p' or $orientation=='portrait')
	{
		$orientation='P';
		$this->wPt=$this->fwPt;
		$this->hPt=$this->fhPt;
	}
	elseif($orientation=='l' or $orientation=='landscape')
	{
		$orientation='L';
		$this->wPt=$this->fhPt;
		$this->hPt=$this->fwPt;
	}
	else $this->Error('Incorrect orientation: '.$orientation);
	$this->CurOrientation=$orientation;

	$this->w=$this->wPt/$this->k;
	$this->h=$this->hPt/$this->k;
}

function _getPageFormat($format) {
		switch (strtoupper($format)) {
			case '4A0': {$format = array(4767.87,6740.79); break;}
			case '2A0': {$format = array(3370.39,4767.87); break;}
			case 'A0': {$format = array(2383.94,3370.39); break;}
			case 'A1': {$format = array(1683.78,2383.94); break;}
			case 'A2': {$format = array(1190.55,1683.78); break;}
			case 'A3': {$format = array(841.89,1190.55); break;}
			case 'A4': default: {$format = array(595.28,841.89); break;}
			case 'A5': {$format = array(419.53,595.28); break;}
			case 'A6': {$format = array(297.64,419.53); break;}
			case 'A7': {$format = array(209.76,297.64); break;}
			case 'A8': {$format = array(147.40,209.76); break;}
			case 'A9': {$format = array(104.88,147.40); break;}
			case 'A10': {$format = array(73.70,104.88); break;}
			case 'B0': {$format = array(2834.65,4008.19); break;}
			case 'B1': {$format = array(2004.09,2834.65); break;}
			case 'B2': {$format = array(1417.32,2004.09); break;}
			case 'B3': {$format = array(1000.63,1417.32); break;}
			case 'B4': {$format = array(708.66,1000.63); break;}
			case 'B5': {$format = array(498.90,708.66); break;}
			case 'B6': {$format = array(354.33,498.90); break;}
			case 'B7': {$format = array(249.45,354.33); break;}
			case 'B8': {$format = array(175.75,249.45); break;}
			case 'B9': {$format = array(124.72,175.75); break;}
			case 'B10': {$format = array(87.87,124.72); break;}
			case 'C0': {$format = array(2599.37,3676.54); break;}
			case 'C1': {$format = array(1836.85,2599.37); break;}
			case 'C2': {$format = array(1298.27,1836.85); break;}
			case 'C3': {$format = array(918.43,1298.27); break;}
			case 'C4': {$format = array(649.13,918.43); break;}
			case 'C5': {$format = array(459.21,649.13); break;}
			case 'C6': {$format = array(323.15,459.21); break;}
			case 'C7': {$format = array(229.61,323.15); break;}
			case 'C8': {$format = array(161.57,229.61); break;}
			case 'C9': {$format = array(113.39,161.57); break;}
			case 'C10': {$format = array(79.37,113.39); break;}
			case 'RA0': {$format = array(2437.80,3458.27); break;}
			case 'RA1': {$format = array(1729.13,2437.80); break;}
			case 'RA2': {$format = array(1218.90,1729.13); break;}
			case 'RA3': {$format = array(864.57,1218.90); break;}
			case 'RA4': {$format = array(609.45,864.57); break;}
			case 'SRA0': {$format = array(2551.18,3628.35); break;}
			case 'SRA1': {$format = array(1814.17,2551.18); break;}
			case 'SRA2': {$format = array(1275.59,1814.17); break;}
			case 'SRA3': {$format = array(907.09,1275.59); break;}
			case 'SRA4': {$format = array(637.80,907.09); break;}
			case 'LETTER': {$format = array(612.00,792.00); break;}
			case 'LEGAL': {$format = array(612.00,1008.00); break;}
			case 'EXECUTIVE': {$format = array(521.86,756.00); break;}
			case 'FOLIO': {$format = array(612.00,936.00); break;}
			case 'B': {$format=array(362.83,561.26 );	 break;}		//	'B' format paperback size 128x198mm
			case 'A': {$format=array(314.65,504.57 );	 break;}		//	'A' format paperback size 111x178mm
			case 'DEMY': {$format=array(382.68,612.28 );  break;}		//	'Demy' format paperback size 135x216mm
			case 'ROYAL': {$format=array(433.70,663.30 );  break;}	//	'Royal' format paperback size 153x234mm
			default: $format = false;
		}
	return $format;
}


function StartProgressBarOutput($mode=1) {
	// must be relative path, or URI (not a file system path)
	if (!defined('_MPDF_URI')) { 
		$this->progressBar = false;
		if ($this->debug) { $this->Error("You need to define _MPDF_URI to use the progress bar!"); }
		else return false; 
	}
	$this->progressBar = $mode;
	if ($this->progbar_altHTML) {
		echo $this->progbar_altHTML;
	}
	else {
	   echo '<html>
	<head>
	<title>mPDF File Progress</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="'._MPDF_URI.'progbar.css" />
		</head>
	<body>
	<div class="main">
		<div class="heading">'.$this->progbar_heading.'</div>
		<div class="demo">
	   ';
	   if ($this->progressBar==2) { echo '		<table width="100%"><tr><td style="width: 50%;"> 
			<span class="barheading">Writing HTML code</span> <br/>

			<div class="progressBar">
			<div id="element1"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box1"></span>
			</td><td style="width: 50%;">
			<span class="barheading">Autosizing elements</span> <br/>
			<div class="progressBar">
			<div id="element4"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box4"></span>
			<br/><br/>
			<span class="barheading">Writing Tables</span> <br/>
			<div class="progressBar">
			<div id="element7"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box7"></span>
			</td></tr>
			<tr><td><br /><br /></td><td></td></tr>
			<tr><td style="width: 50%;"> 
	'; }
	echo '			<span class="barheading">Writing PDF file</span> <br/>
			<div class="progressBar">
			<div id="element2"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box2"></span>
	   ';
	   if ($this->progressBar==2) { echo '
			</td><td style="width: 50%;">
			<span class="barheading">Memory usage</span> <br/>
			<div class="progressBar">
			<div id="element5"  class="innerBar">&nbsp;</div>
			</div>
			<span id="box5">0</span> '.ini_get("memory_limit").'<br />
			<br/><br/>
			<span class="barheading">Memory usage (peak)</span> <br/>
			<div class="progressBar">
			<div id="element6"  class="innerBar">&nbsp;</div>
			</div>
			<span id="box6">0</span> '.ini_get("memory_limit").'<br />
			</td></tr>
			</table>
	   '; }
	   echo '			<br/><br/>
		<span id="box3"></span>

		</div>
	   ';
	}
	ob_flush();
      flush();
}

function UpdateProgressBar($el,$val,$txt='') {
	// $val should be a string - 5 = actual value, +15 = increment

	if ($this->progressBar<2) {
		if ($el>3) { return; }
		else if ($el ==1) { $el = 2; }
	}
	echo '<script type="text/javascript">';
	if ($val) { echo ' document.getElementById(\'element'.$el.'\').style.width=\''.$val.'%\'; '; }
	if ($txt) { echo ' document.getElementById(\'box'.$el.'\').innerHTML=\''.$txt.'\'; '; }
	if ($this->progressBar==2) { 
		$m = round(memory_get_usage()/1048576);
		$m2 = round(memory_get_peak_usage()/1048576);
		$mem = $m * 100 / (ini_get("memory_limit")+0);
		$mem2 = $m2 * 100 / (ini_get("memory_limit")+0);
		echo ' document.getElementById(\'element5\').style.width=\''.$mem.'%\'; '; 
		echo ' document.getElementById(\'element6\').style.width=\''.$mem2.'%\'; '; 
		echo ' document.getElementById(\'box5\').innerHTML=\''.$m.'MB / \'; '; 
		echo ' document.getElementById(\'box6\').innerHTML=\''.$m2.'MB / \'; '; 
	}
	echo '</script>'."\n";
	ob_flush();
	flush();
}



function RestrictUnicodeFonts($res) {
	// $res = array of (Unicode) fonts to restrict to: e.g. norasi|norasiB - language specific
	if (count($res)) {	// Leave full list of available fonts if passed blank array
		$this->available_unifonts = $res;
	}
	else { $this->available_unifonts = $this->default_available_fonts; }
	if (count($this->available_unifonts) == 0) { $this->available_unifonts[] = $this->default_available_fonts[0]; }
	$this->available_unifonts = array_values($this->available_unifonts);
}


function setMBencoding($enc) {
@mb_regex_encoding('UTF-8'); 
	$curr = $this->mb_enc;
	$this->mb_enc = $enc; 
	if (!$this->mb_enc || $curr != $this->mb_enc) { 
		mb_internal_encoding($this->mb_enc); 
		if ($enc == 'UTF-8') { @mb_regex_encoding('UTF-8'); }
//		else if ($enc == 'windows-1252') { @mb_regex_encoding('ISO-8859-1'); }
	}
}


function SetMargins($left,$right,$top) {
	//Set left, top and right margins
	$this->lMargin=$left;
	$this->rMargin=$right;
	$this->tMargin=$top;
}

function ResetMargins() {
	//ReSet left, top margins
	if (($this->forcePortraitHeaders || $this->forcePortraitMargins) && $this->DefOrientation=='P' && $this->CurOrientation=='L') {
	    if (($this->mirrorMargins) && (($this->page)%2==0)) {	// EVEN
		$this->tMargin=$this->orig_rMargin;
		$this->bMargin=$this->orig_lMargin;
	    }
	    else {	// ODD	// OR NOT MIRRORING MARGINS/FOOTERS
		$this->tMargin=$this->orig_lMargin;
		$this->bMargin=$this->orig_rMargin;
	    }
	   $this->lMargin=$this->DeflMargin;
	   $this->rMargin=$this->DefrMargin;
	   $this->MarginCorrection = 0;
	   $this->PageBreakTrigger=$this->h-$this->bMargin;
	}
	else  if (($this->mirrorMargins) && (($this->page)%2==0)) {	// EVEN
		$this->lMargin=$this->DefrMargin;
		$this->rMargin=$this->DeflMargin;
		$this->MarginCorrection = $this->DefrMargin-$this->DeflMargin;

	}
	else {	// ODD	// OR NOT MIRRORING MARGINS/FOOTERS
		$this->lMargin=$this->DeflMargin;
		$this->rMargin=$this->DefrMargin;
		if ($this->mirrorMargins) { $this->MarginCorrection = $this->DeflMargin-$this->DefrMargin; }
	}
	$this->x=$this->lMargin;

}

function SetLeftMargin($margin) {
	//Set left margin
	$this->lMargin=$margin;
	if($this->page>0 and $this->x<$margin) $this->x=$margin;
}

function SetTopMargin($margin) {
	//Set top margin
	$this->tMargin=$margin;
}

function SetRightMargin($margin) {
	//Set right margin
	$this->rMargin=$margin;
}

function SetAutoPageBreak($auto,$margin=0) {
	//Set auto page break mode and triggering margin
	$this->autoPageBreak=$auto;
	$this->bMargin=$margin;
	$this->PageBreakTrigger=$this->h-$margin;
}

function SetDisplayMode($zoom,$layout='continuous') {
	//Set display mode in viewer
	if($zoom=='fullpage' or $zoom=='fullwidth' or $zoom=='real' or $zoom=='default' or !is_string($zoom))
		$this->ZoomMode=$zoom;
	else
		$this->Error('Incorrect zoom display mode: '.$zoom);
	if($layout=='single' or $layout=='continuous' or $layout=='two' or $layout=='default')
		$this->LayoutMode=$layout;
	else
		$this->Error('Incorrect layout display mode: '.$layout);
}

function SetCompression($compress) {
	//Set page compression
	if(function_exists('gzcompress'))	$this->compress=$compress;
	else $this->compress=false;
}

function SetTitle($title) {
	//Title of document // Arrives as UTF-8
	$this->title = $title;
}

function SetSubject($subject) {
	//Subject of document
	$this->subject= $subject;
}

function SetAuthor($author) {
	//Author of document
	$this->author= $author;
}

function SetKeywords($keywords) {
	//Keywords of document
	$this->keywords= $keywords;
}

function SetCreator($creator) {
	//Creator of document
	$this->creator= $creator;
}


function SetAnchor2Bookmark($x) {
	$this->anchor2Bookmark = $x;
}

function AliasNbPages($alias='{nb}') {
	//Define an alias for total number of pages
	$this->aliasNbPg=$alias;
}

function AliasNbPageGroups($alias='{nbpg}') {
	//Define an alias for total number of pages in a group
	$this->aliasNbPgGp=$alias;
}

function SetAlpha($alpha, $bm='Normal', $return=false) {
// alpha: real value from 0 (transparent) to 1 (opaque)
// bm:    blend mode, one of the following:
//          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
//          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
// set alpha for stroking (CA) and non-stroking (ca) operations

	if ($this->PDFA && $alpha!=1) { 
		if (!$this->PDFAauto) { $this->PDFAwarnings[] = "Image opacity must be 100% (Opacity changed to 100%)"; }
		$alpha = 1; 
	}
	$gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
	if ($return) { return sprintf('/GS%d gs', $gs); }
	else { $this->_out(sprintf('/GS%d gs', $gs)); }
}

// mPDF 5.0 - Accepts any Graphic state
function AddExtGState($parms) {
	$n = count($this->extgstates);
	// check if graphics state already exists
	for ($i=1; $i<=$n; $i++) {
	  if (count($this->extgstates[$i]['parms']) == count($parms)) {
	    $same = true;
	    foreach($this->extgstates[$i]['parms'] AS $k=>$v) {
		if (!isset($parms[$k]) || $parms[$k] != $v) { $same = false; break; }
	    }
	    if ($same) { return $i; }
	  }
	}
	$n++;
	$this->extgstates[$n]['parms'] = $parms;
	return $n;
}



function Error($msg) {
	//Fatal error
	header('Content-Type: text/html; charset=utf-8');
	die('<B>mPDF error: </B>'.$msg);
}

function Open() {
	//Begin document
	if($this->state==0)	$this->_begindoc();
}

function Close() {
	if ($this->progressBar) { $this->UpdateProgressBar(2,'2','Closing last page'); }
	//Terminate document
	if($this->state==3)	return;
	if($this->page==0) $this->AddPage($this->CurOrientation);
	if (count($this->divbuffer)) { $this->printdivbuffer(); }

	// BODY Backgrounds
	$s = '';
	$bby = $this->h;
	$bbw = $this->w;
	$bbh = $this->h;
	if ($this->bodyBackgroundColor) {
		$s .= sprintf('%.3f %.3f %.3f rg',$this->bodyBackgroundColor['R']/255,$this->bodyBackgroundColor['G']/255,$this->bodyBackgroundColor['B']/255)."\n";
		$s .= sprintf('%.3f %.3f %.3f %.3f re f',0,$bby*$this->k,$bbw*$this->k,-$bbh*$this->k)."\n";
	}



	$s .= $this->PrintPageBackgrounds();
	$this->pages[$this->page] = preg_replace('/(___BACKGROUND___PATTERNS'.date('jY').')/', "\n".$s."\n".'\\1', $this->pages[$this->page]);
	$this->pageBackgrounds = array();

	if (!$this->TOCmark) { //Page footer
		$this->InFooter=true;
		$this->Footer();
		$this->InFooter=false;
	}

	//Close page
	$this->_endpage();

	//Close document
	$this->_enddoc();
}

function _resizeBackgroundImage($imw, $imh, $cw, $ch, $resize=0, $repx, $repy) {
	$cw = $cw*$this->k;
	$ch = $ch*$this->k;
	if (!$resize) { return array($imw, $imh, $repx, $repy); }
	if ($resize==1 && $imw > $cw) {
		$h = $imh * $cw/$imw;
		$repx = false;
		return array($cw, $h, $repx, $repy); 
	}
	else if ($resize==2 && $imh > $ch) {
		$w = $imw * $ch/$imh;
		$repy = false;
		return array($w, $ch, $repx, $repy); 
	}
	else if ($resize==3) {
		$w = $imw;
		$h = $imh;
		$saverepx = $repx;
		if ($w > $cw) {
			$h = $h * $cw/$w;
			$w = $cw;
			$repx = false;
		}
		if ($h > $ch) {
			$w = $w * $ch/$h;
			$h = $ch;
			$repy = false;
			$repx = $saverepx;
		}
		return array($w, $h, $repx, $repy); 
	}
	else if ($resize==4) {
		$h = $imh * $cw/$imw;
		$repx = false;
		return array($cw, $h, $repx, $repy); 
	}
	else if ($resize==5) {
		$w = $imw * $ch/$imh;
		$repy = false;
		return array($w, $ch, $repx, $repy); 
	}
	else if ($resize==6) {
		$repx = false;
		$repy = false;
		return array($cw, $ch, $repx, $repy); 
	}
	return array($imw, $imh, $repx, $repy);
}


function PrintPageBackgrounds($adjustmenty=0) {
	$s = '';
	ksort($this->pageBackgrounds);
	foreach($this->pageBackgrounds AS $bl=>$pbs) {
		foreach ($pbs AS $pb) {
		  if (!isset($pb['image_id']) && !isset($pb['gradient'])) {	// Background colour
			if (isset($pb['clippath']) && $pb['clippath']) { $s .= $pb['clippath']."\n"; }
			$s .= sprintf('%.3f %.3f %.3f rg',$pb['col']['R']/255,$pb['col']['G']/255,$pb['col']['B']/255)."\n";
			$s .= sprintf('%.3f %.3f %.3f %.3f re f',$pb['x']*$this->k,($this->h-$pb['y'])*$this->k,$pb['w']*$this->k,-$pb['h']*$this->k)."\n";
			if (isset($pb['clippath']) && $pb['clippath']) { $s .= 'Q'."\n"; }
		  }
		}
	}
	return $s;
}

// Depracated - can use AddPage for all
function AddPages($orientation='',$condition='', $resetpagenum='', $pagenumstyle='', $suppress='',$mgl='',$mgr='',$mgt='',$mgb='',$mgh='',$mgf='',$ohname='',$ehname='',$ofname='',$efname='',$ohvalue=0,$ehvalue=0,$ofvalue=0,$efvalue=0,$pagesel='',$newformat='')
{
	$this->AddPage($orientation,$condition,$resetpagenum, $pagenumstyle, $suppress,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf, $ohname, $ehname, $ofname, $efname, $ohvalue, $ehvalue, $ofvalue, $efvalue,$pagesel,$newformat);
}


function AddPageByArray($a) {
	if (!is_array($a)) { $a = array(); }

	$orientation = (isset($a['orientation']) ? $a['orientation'] : '');
	$condition = (isset($a['condition']) ? $a['condition'] : '');
	$resetpagenum = (isset($a['resetpagenum']) ? $a['resetpagenum'] : '');
	$pagenumstyle = (isset($a['pagenumstyle']) ? $a['pagenumstyle'] : '');
	$suppress = (isset($a['suppress']) ? $a['suppress'] : '');
	$mgl = (isset($a['mgl']) ? $a['mgl'] : '');
	$mgr = (isset($a['mgr']) ? $a['mgr'] : '');
	$mgt = (isset($a['mgt']) ? $a['mgt'] : '');
	$mgb = (isset($a['mgb']) ? $a['mgb'] : '');
	$mgh = (isset($a['mgh']) ? $a['mgh'] : '');
	$mgf = (isset($a['mgf']) ? $a['mgf'] : '');
	$ohname = (isset($a['ohname']) ? $a['ohname'] : '');
	$ehname = (isset($a['ehname']) ? $a['ehname'] : '');
	$ofname = (isset($a['ofname']) ? $a['ofname'] : '');
	$efname = (isset($a['efname']) ? $a['efname'] : '');
	$ohvalue = (isset($a['ohvalue']) ? $a['ohvalue'] : 0);
	$ehvalue = (isset($a['ehvalue']) ? $a['ehvalue'] : 0);
	$ofvalue = (isset($a['ofvalue']) ? $a['ofvalue'] : 0);
	$efvalue = (isset($a['efvalue']) ? $a['efvalue'] : 0);
	$pagesel = (isset($a['pagesel']) ? $a['pagesel'] : '');
	$newformat = (isset($a['newformat']) ? $a['newformat'] : '');

	$this->AddPage($orientation,$condition,$resetpagenum, $pagenumstyle, $suppress,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf, $ohname, $ehname, $ofname, $efname, $ohvalue, $ehvalue, $ofvalue, $efvalue,$pagesel,$newformat);

}




function AddPage($orientation='',$condition='', $resetpagenum='', $pagenumstyle='', $suppress='',$mgl='',$mgr='',$mgt='',$mgb='',$mgh='',$mgf='',$ohname='',$ehname='',$ofname='',$efname='',$ohvalue=0,$ehvalue=0,$ofvalue=0,$efvalue=0,$pagesel='',$newformat='')
{


	//Start a new page
	if($this->state==0) $this->Open();

	$bak_cml = $this->cMarginL;
	$bak_cmr = $this->cMarginR; 
	$bak_dw = $this->divwidth;


	$bak_lh = $this->lineheight;

	$orientation = substr(strtoupper($orientation),0,1);
	$condition = strtoupper($condition);


	if ($condition == 'NEXT-EVEN') {	// always adds at least one new page to create an Even page
	   if (!$this->mirrorMargins) { $condition = ''; }
	   else { 
		$this->AddPage($this->CurOrientation,'O'); 
		$condition = ''; 
	   }
	}
	if ($condition == 'NEXT-ODD') {	// always adds at least one new page to create an Odd page
	   if (!$this->mirrorMargins) { $condition = ''; }
	   else { 
		$this->AddPage($this->CurOrientation,'E'); 
		$condition = ''; 
	   }
	}


	if ($condition == 'E') {	// only adds new page if needed to create an Even page
	   if (!$this->mirrorMargins || ($this->page)%2==0) { return false; }
	}
	if ($condition == 'O') {	// only adds new page if needed to create an Odd page
	   if (!$this->mirrorMargins || ($this->page)%2==1) { return false; }
	}

	if ($resetpagenum || $pagenumstyle || $suppress) {
		$this->PageNumSubstitutions[] = array('from'=>($this->page+1), 'reset'=> $resetpagenum, 'type'=>$pagenumstyle, 'suppress'=>$suppress);
	}


	$save_kwt = $this->kwt;
	$this->kwt = 0;

	// Paint Div Border if necessary
   	//PAINTS BACKGROUND COLOUR OR BORDERS for DIV - DISABLED FOR COLUMNS (cf. AcceptPageBreak) AT PRESENT in ->PaintDivBB
   	if (!$this->ColActive && $this->blklvl > 0) {
		if (isset($this->blk[$this->blklvl]['y0']) && $this->y == $this->blk[$this->blklvl]['y0']) {  
			if (isset($this->blk[$this->blklvl]['startpage'])) { $this->blk[$this->blklvl]['startpage']++; }
			else { $this->blk[$this->blklvl]['startpage'] = 1; }
		}
		if ((isset($this->blk[$this->blklvl]['y0']) && $this->y > $this->blk[$this->blklvl]['y0']) || $this->flowingBlockAttr['is_table'] ) { $toplvl = $this->blklvl; }
		else { $toplvl = $this->blklvl-1; }
		$sy = $this->y;
		for ($bl=1;$bl<=$toplvl;$bl++) {
			$this->PaintDivBB('pagebottom',0,$bl);
		}
		$this->y = $sy;
		// RESET block y0 and x0 - see below
	}

	// BODY Backgrounds
	if ($this->page > 0) {
		$s = '';
		$bby = $this->h;
		$bbw = $this->w;
		$bbh = $this->h;
		if ($this->bodyBackgroundColor) {
			$s .= sprintf('%.3f %.3f %.3f rg',$this->bodyBackgroundColor['R']/255,$this->bodyBackgroundColor['G']/255,$this->bodyBackgroundColor['B']/255)."\n";
			$s .= sprintf('%.3f %.3f %.3f %.3f re f',0,$bby*$this->k,$bbw*$this->k,-$bbh*$this->k)."\n";
		}

		$s .= $this->PrintPageBackgrounds();
		$this->pages[$this->page] = preg_replace('/(___BACKGROUND___PATTERNS'.date('jY').')/', "\n".$s."\n".'\\1', $this->pages[$this->page]);
		$this->pageBackgrounds = array();
	}

	$save_kt = $this->keep_block_together;	// mPDF 5.0
	$this->keep_block_together = 0;

	$save_cols = false;

	$family=$this->FontFamily;
	$style=$this->FontStyle.($this->U ? 'U' : '').($this->S ? 'S' : '');
	$size=$this->FontSizePt;
	$this->ColumnAdjust = true;	// enables column height adjustment for the page
	$lw=$this->LineWidth;
	$dc=$this->DrawColor;
	$fc=$this->FillColor;
	$tc=$this->TextColor;
	$cf=$this->ColorFlag;
	if($this->page>0)
	{
		//Page footer
		$this->InFooter=true;

		$this->Reset();
		$this->pageoutput[$this->page] = array();

		$this->Footer();
		//Close page
		$this->_endpage();
	}





	//Start new page
	$this->_beginpage($orientation,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf,$ohname,$ehname,$ofname,$efname,$ohvalue,$ehvalue,$ofvalue,$efvalue,$pagesel,$newformat);
	if ($this->docTemplate) {
		$pagecount = $this->SetSourceFile($this->docTemplate);
		if (($this->page - $this->docTemplateStart) > $pagecount) {
			if ($this->docTemplateContinue) { 
				$tplIdx = $this->ImportPage($pagecount);
				$this->UseTemplate($tplIdx);
			}
		}
		else {
			$tplIdx = $this->ImportPage(($this->page - $this->docTemplateStart));
			$this->UseTemplate($tplIdx);
		}
	}
	if ($this->pageTemplate) {
		$this->UseTemplate($this->pageTemplate);
	}

	// Tiling Patterns	// Moved here mPDF 4.0
	$this->_out('___PAGE___START'.date('jY'));	// mPDF 5.0
	$this->_out('___BACKGROUND___PATTERNS'.date('jY'));
	$this->_out('___HEADER___MARKER'.date('jY'));
	$this->pageBackgrounds = array();

	//Set line cap style to square
	$this->_out('2 J');
	//Set line width
	$this->LineWidth=$lw;
	$this->_out(sprintf('%.3f w',$lw*$this->k));
	//Set font
	if($family)	$this->SetFont($family,$style,$size,true,true);	// forces write
	//Set colors
	$this->DrawColor=$dc;
	if($dc!='0 G') $this->_out($dc);
	$this->FillColor=$fc;
	if($fc!='0 g') $this->_out($fc);
	$this->TextColor=$tc;
	$this->ColorFlag=$cf;

	//Page header
	$this->Header();

	//Restore line width
	if($this->LineWidth!=$lw)
	{
		$this->LineWidth=$lw;
		$this->_out(sprintf('%.3f w',$lw*$this->k));
	}
	//Restore font
	if($family)	$this->SetFont($family,$style,$size,true,true);	// forces write
	//Restore colors
	if($this->DrawColor!=$dc)
	{
		$this->DrawColor=$dc;
		$this->_out($dc);
	}
	if($this->FillColor!=$fc)
	{
		$this->FillColor=$fc;
		$this->_out($fc);
	}
	$this->TextColor=$tc;
	$this->ColorFlag=$cf;
 	$this->InFooter=false;



   	//RESET BLOCK BORDER TOP
   	if (!$this->ColActive) {
		for($bl=1;$bl<=$this->blklvl;$bl++) {
			$this->blk[$bl]['y0'] = $this->y;
			if (isset($this->blk[$bl]['x0'])) { $this->blk[$bl]['x0'] += $this->MarginCorrection; }
			else { $this->blk[$bl]['x0'] = $this->MarginCorrection; }
			// Added mPDF 3.0 Float DIV
			$this->blk[$bl]['marginCorrected'][$this->page] = true; 
		}
	}


	$this->kwt = $save_kwt;

	$this->keep_block_together = $save_kt ;	// mPDF 5.0


	$this->cMarginL = $bak_cml;
	$this->cMarginR = $bak_cmr;
	$this->divwidth = $bak_dw;

	$this->lineheight = $bak_lh;
}


function PageNo() {
	//Get current page number
	return $this->page;
}

function SetDrawColor($r,$g=-1,$b=-1,$col4=-1) {
	//Set color for all stroking operations
	if(($r==0 and $g==0 and $b==0 && $col4 == -1) or $g==-1)	$this->DrawColor=sprintf('%.3f G',$r/255);
	else if ($col4 == -1) $this->DrawColor=sprintf('%.3f %.3f %.3f RG',$r/255,$g/255,$b/255);
	else {
		// CMYK
		if ($this->PDFA) { $this->Error("PDFA1-b does not permit CMYK colours (fn. SetDrawColor)."); }
		$this->DrawColor = sprintf('%.3f %.3f %.3f %.3f K', $r/100, $g/100, $b/100, $col4/100);
	}
	if($this->page>0 && ((isset($this->pageoutput[$this->page]['DrawColor']) && $this->pageoutput[$this->page]['DrawColor'] != $this->DrawColor) || !isset($this->pageoutput[$this->page]['DrawColor']) || $this->keep_block_together)) { $this->_out($this->DrawColor); }
	$this->pageoutput[$this->page]['DrawColor'] = $this->DrawColor;
}

function SetFillColor($r,$g=-1,$b=-1,$col4=-1) {
	//Set color for all filling operations
	if(($r==0 and $g==0 and $b==0 && $col4 == -1) or $g==-1)	$this->FillColor=sprintf('%.3f g',$r/255);
	else if ($col4 == -1) $this->FillColor=sprintf('%.3f %.3f %.3f rg',$r/255,$g/255,$b/255);
	else {
		// CMYK
		if ($this->PDFA) { $this->Error("PDFA1-b does not permit CMYK colours (fn. SetFillColor)."); }
		$this->FillColor = sprintf('%.3f %.3f %.3f %.3f k', $r/100, $g/100, $b/100, $col4/100);
	}
	$this->ColorFlag = ($this->FillColor != $this->TextColor);
	if($this->page>0 && ((isset($this->pageoutput[$this->page]['FillColor']) && $this->pageoutput[$this->page]['FillColor'] != $this->FillColor) || !isset($this->pageoutput[$this->page]['FillColor']) || $this->keep_block_together)) { $this->_out($this->FillColor); }
	$this->pageoutput[$this->page]['FillColor'] = $this->FillColor;
}

function SetTextColor($r,$g=-1,$b=-1,$col4=-1) {
	//Set color for text
	if(($r==0 and $g==0 and $b==0 && $col4 == -1) or $g==-1)	$this->TextColor=sprintf('%.3f g',$r/255);
	else if ($col4 == -1) $this->TextColor=sprintf('%.3f %.3f %.3f rg',$r/255,$g/255,$b/255);
	else {
		// CMYK
		if ($this->PDFA) { $this->Error("PDFA1-b does not permit CMYK colours (fn. SetTextColor)."); }
		$this->TextColor = sprintf('%.3f %.3f %.3f %.3f k', $r/100, $g/100, $b/100, $col4/100);
	}
	$this->ColorFlag = ($this->FillColor != $this->TextColor);
}

// mPDF 5.0
function _getCharWidth(&$cw, $u, $isdef=true) {
	if ($u==0) { $w = false; }
	else { $w = (ord($cw[$u*2]) << 8) + ord($cw[$u*2+1]); }
	if ($w == 65535) { return 0; }
	else if ($w) { return $w; }
	else if ($isdef) { return false; }
	else { return 0; }
}
// mPDF 5.0
function _charDefined(&$cw, $u) {
	if ($u==0) { return false; }
	$w = (ord($cw[$u*2]) << 8) + ord($cw[$u*2+1]);
	if ($w) { return true; }
	else { return false; }
}

function GetStringWidth($s) {
			//Get width of a string in the current font
			$s = (string)$s;
			$cw = &$this->CurrentFont['cw'];
			$w = 0;

			// mPDF ITERATION
			if ($this->iterationCounter) $s = preg_replace('/{iteration ([a-zA-Z0-9_]+)}/', '\\1', $s);

			if (!$this->usingCoreFont) {
				$unicode = $this->UTF8StringToArray($s);
				if ($this->CurrentFont['type'] == 'Type0') {	// CJK Adobe fonts
					foreach($unicode as $char) {
						if ($char == 173) { continue; }	// Soft Hyphens
						elseif (isset($cw[$char])) { $w+=$cw[$char]; } 
						elseif(isset($this->CurrentFont['MissingWidth'])) { $w += $this->CurrentFont['MissingWidth']; }
						else { $w += 500; }
					}
				}
				else { 
					foreach($unicode as $char) {
						if ($char == 173) { continue; }	// Soft Hyphens
						else if ($this->S && isset($this->upperCase[$char])) {
							$charw = $this->_getCharWidth($cw,$this->upperCase[$char]);
							if ($charw!==false) { 
								$charw = $charw*$this->smCapsScale * $this->smCapsStretch/100;
								$w+=$charw; 
							}
							elseif(isset($this->CurrentFont['desc']['MissingWidth'])) { $w += $this->CurrentFont['desc']['MissingWidth']; }
							elseif(isset($this->CurrentFont['MissingWidth'])) { $w += $this->CurrentFont['MissingWidth']; }
							else { $w += 500; }
						}
						else {
							$charw = $this->_getCharWidth($cw,$char);
							if ($charw!==false) { $w+=$charw; } 	// mPDF 5.0
							elseif(isset($this->CurrentFont['desc']['MissingWidth'])) { $w += $this->CurrentFont['desc']['MissingWidth']; }
							elseif(isset($this->CurrentFont['MissingWidth'])) { $w += $this->CurrentFont['MissingWidth']; }
							else { $w += 500; }
						}
					}
				}
			} 
			else {
				$l = strlen($s);
				for($i=0; $i<$l; $i++) {
					// Soft Hyphens chr(173)
					if ($s[$i] == chr(173) && $this->FontFamily!='csymbol' && $this->FontFamily!='czapfdingbats') { 
						continue;
					}
					else if ($this->S && isset($this->upperCase[ord($s[$i])])) { 
						$charw = $cw[chr($this->upperCase[ord($s[$i])])];
						if ($charw!==false) { 
							$charw = $charw*$this->smCapsScale * $this->smCapsStretch/100;
							$w+=$charw; 
						}
					}
					else if (isset($cw[$s[$i]])) { $w += $cw[$s[$i]]; } 
					else if (isset($cw[ord($s[$i])])) { $w += $cw[ord($s[$i])]; }
				}

			}
			unset($cw);
			return ($w * $this->FontSize/ 1000);
}

function SetLineWidth($width) {
	//Set line width
	$this->LineWidth=$width;
	$lwout = (sprintf('%.3f w',$width*$this->k));
	if($this->page>0 && ((isset($this->pageoutput[$this->page]['LineWidth']) && $this->pageoutput[$this->page]['LineWidth'] != $lwout) || !isset($this->pageoutput[$this->page]['LineWidth']) || $this->keep_block_together)) {
		 $this->_out($lwout); 
	}
	$this->pageoutput[$this->page]['LineWidth'] = $lwout;
}

function Line($x1,$y1,$x2,$y2) {
	//Draw a line
	$this->_out(sprintf('%.3f %.3f m %.3f %.3f l S',$x1*$this->k,($this->h-$y1)*$this->k,$x2*$this->k,($this->h-$y2)*$this->k));
}

function Arrow($x1,$y1,$x2,$y2,$headsize=3,$fill='B',$angle=25) {
  //F == fill //S == stroke //B == stroke and fill 
  // angle = splay of arrowhead - 1 - 89 degrees
  if($fill=='F')	$fill='f';
  elseif($fill=='FD' or $fill=='DF' or $fill=='B') $fill='B';
  else $fill='S';
  $a = atan2(($y2-$y1),($x2-$x1));
  $b = $a + deg2rad($angle);
  $c = $a - deg2rad($angle);
  $x3 = $x2 - ($headsize* cos($b));
  $y3 = $this->h-($y2 - ($headsize* sin($b)));
  $x4 = $x2 - ($headsize* cos($c));
  $y4 = $this->h-($y2 - ($headsize* sin($c)));

  $x5 = $x3-($x3-$x4)/2;	// mid point of base of arrowhead - to join arrow line to
  $y5 = $y3-($y3-$y4)/2;

  $s = '';
  $s.=sprintf('%.3f %.3f m %.3f %.3f l S',$x1*$this->k,($this->h-$y1)*$this->k,$x5*$this->k,$y5*$this->k);
  $this->_out($s);

  $s = '';
  $s.=sprintf('%.3f %.3f m %.3f %.3f l %.3f %.3f l %.3f %.3f l %.3f %.3f l ',$x5*$this->k,$y5*$this->k,$x3*$this->k,$y3*$this->k,$x2*$this->k,($this->h-$y2)*$this->k,$x4*$this->k,$y4*$this->k,$x5*$this->k,$y5*$this->k);
  $s.=$fill;
  $this->_out($s);
}


function Rect($x,$y,$w,$h,$style='') {
	//Draw a rectangle
	if($style=='F')	$op='f';
	elseif($style=='FD' or $style=='DF') $op='B';
	else $op='S';
	$this->_out(sprintf('%.3f %.3f %.3f %.3f re %s',$x*$this->k,($this->h-$y)*$this->k,$w*$this->k,-$h*$this->k,$op));
}

function AddFont($family,$style='') {	// mPDF 5.0
	if(empty($family)) { return; }
	$family = strtolower($family);
	$style=strtoupper($style);
	$style=str_replace('U','',$style);
	if($style=='IB') $style='BI';
	$fontkey = $family.$style;
	// check if the font has been already added
	if(isset($this->fonts[$fontkey])) {
		return;
	}

	if (in_array($family,$this->available_CJK_fonts)) { 
		if (empty($this->Big5_widths)) { require(_MPDF_PATH . 'includes/CJKdata.php'); }
		$this->AddCJKFont($family);	// don't need to add style
		return; 
	}

	if ($this->usingCoreFont) { die("mPDF Error - problem with Font management"); }

	$stylekey = $style;
	if (!$style) { $stylekey = 'R'; }

	if (!isset($this->fontdata[$family][$stylekey]) || !$this->fontdata[$family][$stylekey]) {
		die('mPDF Error - Font is not supported - '.$family.' '.$style);
	}

	$name = '';
	$originalsize = 0;
	$sip = false;
	$smp = false;
	$BMPselected = false;
	@include(_MPDF_TTFONTDATAPATH.$fontkey.'.mtx.php');

	$ttffile = '';
	if (defined('_MPDF_SYSTEM_TTFONTS')) {
		$ttffile = _MPDF_SYSTEM_TTFONTS.$this->fontdata[$family][$stylekey];
		if (!file_exists($ttffile)) { $ttffile = ''; }
	}
	if (!$ttffile) {
		$ttffile = _MPDF_TTFONTPATH.$this->fontdata[$family][$stylekey];
		if (!file_exists($ttffile)) { die("mPDF Error - cannot find TTF TrueType font file - ".$ttffile); }
	}
	$ttfstat = stat($ttffile);

	if (isset($this->fontdata[$family]['TTCfontID'][$stylekey])) { $TTCfontID = $this->fontdata[$family]['TTCfontID'][$stylekey]; }
	else { $TTCfontID = 0; }


	// mPDF 5.0Beta.16
	$BMPonly = false;
	if (in_array($family,$this->BMPonly)) { $BMPonly = true; }
	$regenerate = false;
	if ($BMPonly && !$BMPselected) { $regenerate = true; }
	else if (!$BMPonly && $BMPselected) { $regenerate = true; }

	if (!isset($name) || $originalsize != $ttfstat['size'] || $regenerate) {
		$mqr=$this->_getMQR();	// mPDF 5.0
		if ($mqr) { set_magic_quotes_runtime(0); }
		if (!class_exists('TTFontFile', false)) { include(_MPDF_PATH .'classes/ttfontsuni.php'); }
		$ttf = new TTFontFile();
		// mPDF 5.0.03
		$ttf->getMetrics($ttffile, $TTCfontID, $this->debugfonts, $BMPonly);
		$cw = $ttf->charWidths;
		$name = preg_replace('/[ ()]/','',$ttf->fullName);
		$sip = $ttf->sipset;
		$smp = $ttf->smpset;

		//$name = $ttf->familyName;
		//if (preg_match('/(bold|italic|oblique|heavy)/i',$ttf->styleName)) { $name .= ','.$ttf->styleName; }
		//$name = preg_replace('/[()]/','',$name);
		//$name = preg_replace('/[ ]/','#20',$name);

		$desc= array('Ascent'=>round($ttf->ascent),
		'Descent'=>round($ttf->descent),
		'CapHeight'=>round($ttf->capHeight),
		'Flags'=>$ttf->flags,
		'FontBBox'=>'['.round($ttf->bbox[0])." ".round($ttf->bbox[1])." ".round($ttf->bbox[2])." ".round($ttf->bbox[3]).']',
		'ItalicAngle'=>$ttf->italicAngle,
		'StemV'=>round($ttf->stemV),
		'MissingWidth'=>round($ttf->defaultWidth));
		$panose = '';
		// mPDF 5.0
		if (count($ttf->panose)) { $panose = $ttf->sFamilyClass.' '.$ttf->sFamilySubClass.' '.implode(' ',$ttf->panose); }
		$up = round($ttf->underlinePosition);
		$ut = round($ttf->underlineThickness);
		$originalsize = $ttfstat['size']+0;
		$type = 'TTF';
		//Generate metrics .php file
		$s='<?php'."\n";
		$s.='$name=\''.$name."';\n";
		$s.='$type=\''.$type."';\n";
		$s.='$desc='.var_export($desc,true).";\n";
		$s.='$up='.$up.";\n";
		$s.='$ut='.$ut.";\n";
		$s.='$ttffile=\''.$ttffile."';\n";
		$s.='$TTCfontID=\''.$TTCfontID."';\n";
		$s.='$originalsize='.$originalsize.";\n";
		if ($sip) $s.='$sip=true;'."\n";
		else $s.='$sip=false;'."\n";
		if ($smp) $s.='$smp=true;'."\n";
		else $s.='$smp=false;'."\n";
		if ($BMPonly) $s.='$BMPselected=true;'."\n";
		else $s.='$BMPselected=false;'."\n";
		$s.='$fontkey=\''.$fontkey."';\n";
		$s.='$panose=\''.$panose."';\n";	// mPDF 5.0
		$s.="?>";
		if (is_writable(dirname(_MPDF_TTFONTDATAPATH.'x'))) {
			$fh = fopen(_MPDF_TTFONTDATAPATH.$fontkey.'.mtx.php',"w");
			fwrite($fh,$s,strlen($s));
			fclose($fh);
			$fh = fopen(_MPDF_TTFONTDATAPATH.$fontkey.'.cw.dat',"wb");
			fwrite($fh,$cw,strlen($cw));
			fclose($fh);
			@unlink(_MPDF_TTFONTDATAPATH.$fontkey.'.cgm');
			@unlink(_MPDF_TTFONTDATAPATH.$fontkey.'.z');
			@unlink(_MPDF_TTFONTDATAPATH.$fontkey.'.cw127.php');
			@unlink(_MPDF_TTFONTDATAPATH.$fontkey.'.cw');
		}
		else if ($this->debugfonts) { $this->Error('Cannot write to the font caching directory - '._MPDF_TTFONTDATAPATH); }
		unset($ttf);
		if ($mqr) { set_magic_quotes_runtime($mqr); }
	}
	else {
		$cw = @file_get_contents(_MPDF_TTFONTDATAPATH.$fontkey.'.cw.dat'); 
	}

	if (isset($this->fontdata[$family]['indic']) && $this->fontdata[$family]['indic']) { $indic = true; }
	else { $indic = false; }
	if (isset($this->fontdata[$family]['sip-ext']) && $this->fontdata[$family]['sip-ext']) { $sipext = $this->fontdata[$family]['sip-ext']; }
	else { $sipext = ''; }


	$i = count($this->fonts)+$this->extraFontSubsets+1;
	if ($sip || $smp) {	// mPDF 5.0.03 Added SMP
		$this->fonts[$fontkey] = array('i'=>$i, 'type'=>$type, 'name'=>$name, 'desc'=>$desc, 'panose'=>$panose, 'up'=>$up, 'ut'=>$ut, 'cw'=>$cw, 'ttffile'=>$ttffile, 'fontkey'=>$fontkey, 'subsets'=>array(0=>range(0,127)), 'subsetfontids'=>array($i), 'used'=>false, 'indic'=>$indic, 'sip'=>$sip, 'sipext'=>$sipext, 'smp'=>$smp, 'TTCfontID' => $TTCfontID);
	}
	else  {
		$this->fonts[$fontkey] = array('i'=>$i, 'type'=>$type, 'name'=>$name, 'desc'=>$desc, 'panose'=>$panose, 'up'=>$up, 'ut'=>$ut, 'cw'=>$cw, 'ttffile'=>$ttffile, 'fontkey'=>$fontkey, 'subset'=>range(0,127), 'used'=>false, 'indic'=>$indic, 'sip'=>$sip, 'sipext'=>$sipext, 'smp'=>$smp, 'TTCfontID' => $TTCfontID );
	}

	$this->FontFiles[$fontkey]=array('length1'=>$originalsize, 'type'=>"TTF", 'ttffile'=>$ttffile, 'sip'=>$sip, 'smp'=>$smp);
	unset($cw);
}



function SetFont($family,$style='',$size=0, $write=true, $forcewrite=false) {
	$family=strtolower($family);
	if($family=='') { 
		if ($this->FontFamily) { $family=$this->FontFamily; }
		else if ($this->default_font) { $family=$this->default_font; }
		else { $this->Error("No font or default font set!"); }
	}

	$this->ReqFontStyle = $style;	// required or requested style - used later for artificial bold/italic

	if (($family == 'csymbol') || ($family == 'czapfdingbats')  || ($family == 'ctimes')  || ($family == 'ccourier') || ($family == 'chelvetica')) { 
		if ($this->PDFA) {
		   if ($family == 'csymbol' || $family == 'czapfdingbats') { 
			$this->Error("Symbol and Zapfdingbats cannot be embedded in mPDF (required for PDFA1-b).");
		   }
		   if ($family == 'ctimes'  || $family == 'ccourier' || $family == 'chelvetica') { 
			if (!$this->PDFAauto) { $this->PDFAwarnings[] = "Core Adobe font ".ucfirst($family)." cannot be embedded in mPDF, which is required for PDFA1-b. (Embedded font will be substituted.)"; }
			if ($family == 'chelvetica') { $family = 'sans'; }
			if ($family == 'ctimes') { $family = 'serif'; }
			if ($family == 'ccourier') { $family = 'mono'; }
		   }
		   $this->usingCoreFont = false;
		}
		else { $this->usingCoreFont = true; }
	}
	else {  $this->usingCoreFont = false; }

	if($family=='csymbol' or $family=='czapfdingbats') { $style=''; }
	$style=strtoupper($style);
	if(strpos($style,'U')!==false) {
		$this->U=true;
		$style=str_replace('U','',$style);
	}
	else { $this->U=false; }
	if(strpos($style,'S')!==false) {	// mPDF 5.0
		$this->S=true;
		$style=str_replace('S','',$style);
	}
	else { $this->S=false; }
	if ($style=='IB') $style='BI';
	if ($size==0) $size=$this->FontSizePt;

	$fontkey=$family.$style;

	$stylekey = $style;	// mPDF 5.0
	if (!$stylekey) { $stylekey = "R"; }

	if (!$this->onlyCoreFonts && !$this->usingCoreFont) {
		// CJK fonts
		if (in_array($fontkey,$this->available_CJK_fonts)) {
			if(!isset($this->fonts[$fontkey])) {	// already added
				if (empty($this->Big5_widths)) { require(_MPDF_PATH . 'includes/CJKdata.php'); }
				$this->AddCJKFont($family);	// don't need to add style
			}
		}
		// Test to see if requested font/style is available - or substitute
		else if (!in_array($fontkey,$this->available_unifonts)) {
			// If font[nostyle] exists - set it
			if (in_array($family,$this->available_unifonts)) {
				$style = '';
			}

			// Else if only one font available - set it (assumes if only one font available it will not have a style)
			else if (count($this->available_unifonts) == 1) {
				$family = $this->available_unifonts[0];
				$style = '';
			}

			else {
				$found = 0;
				// else substitute font of similar type
				if (in_array($family,$this->sans_fonts)) { 
					$i = array_intersect($this->sans_fonts,$this->available_unifonts);
					if (count($i)) {
						$i = array_values($i);
						// with requested style if possible
						if (!in_array(($i[0].$style),$this->available_unifonts)) {
							$style = '';
						}
						$family = $i[0]; 
						$found = 1;
					}
				}
				else if (in_array($family,$this->serif_fonts)) { 
					$i = array_intersect($this->serif_fonts,$this->available_unifonts);
					if (count($i)) {
						$i = array_values($i);
						// with requested style if possible
						if (!in_array(($i[0].$style),$this->available_unifonts)) {
							$style = '';
						}
						$family = $i[0]; 
						$found = 1;
					}
				}
				else if (in_array($family,$this->mono_fonts)) {
					$i = array_intersect($this->mono_fonts,$this->available_unifonts);
					if (count($i)) {
						$i = array_values($i);
						// with requested style if possible
						if (!in_array(($i[0].$style),$this->available_unifonts)) {
							$style = '';
						}
						$family = $i[0]; 
						$found = 1;
					}
				}

				if (!$found) {
					// set first available font
					$fs = $this->available_unifonts[0];
					preg_match('/^([a-z_0-9\-]+)([BI]{0,2})$/',$fs,$fas);	// mPDF 5.0 Allow "-"
					// with requested style if possible
					$ws = $fas[1].$style;
					if (in_array($ws,$this->available_unifonts)) {
						$family = $fas[1]; // leave $style as is
					}
					else if (in_array($fas[1],$this->available_unifonts)) {
					// or without style
						$family = $fas[1];
						$style = '';
					}
					else {
					// or with the style specified 
						$family = $fas[1];
						$style = $fas[2];
					}
				}
			}
			$fontkey = $family.$style; 
		}
		// try to add font (if not already added)
		$this->AddFont($family, $style);

		//Test if font is already selected
		if(($this->FontFamily == $family) AND ($this->FontStyle == $style) AND ($this->FontSizePt == $size) && !$forcewrite) {
			return $family;
		}

		$fontkey = $family.$style; 

		//Select it
		$this->FontFamily = $family;
		$this->FontStyle = $style;
		$this->FontSizePt = $size;
		$this->FontSize = $size / $this->k;
		$this->CurrentFont = &$this->fonts[$fontkey];
		if ($write) { 
			$fontout = (sprintf('BT /F%d %.3f Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
			// Edited mPDF 3.0
			if($this->page>0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']) || $this->keep_block_together)) { $this->_out($fontout); }
			$this->pageoutput[$this->page]['Font'] = $fontout;
		}



		// Added - currentfont (lowercase) used in HTML2PDF
		$this->currentfontfamily=$family;
		$this->currentfontsize=$size;
		$this->currentfontstyle=$style.($this->U ? 'U' : '').($this->S ? 'S' : '');
		$this->setMBencoding('UTF-8');
	}

	else { 	// if using core fonts


		if ($this->PDFA) {
			$this->Error('Core Adobe fonts cannot be embedded in mPDF (required for PDFA1-b) - cannot use option to use core fonts.');
		}
		$this->setMBencoding('windows-1252');

		//Test if font is already selected
		if(($this->FontFamily == $family) AND ($this->FontStyle == $style) AND ($this->FontSizePt == $size) && !$forcewrite) {
			return $family;
		}

		if (!isset($this->CoreFonts[$fontkey])) {
			if (in_array($family,$this->serif_fonts)) { $family = 'ctimes'; }
			else if (in_array($family,$this->mono_fonts)) { $family = 'ccourier'; }
			else { $family = 'chelvetica'; }
			$this->usingCoreFont = true;
			$fontkey = $family.$style; 
		}

		if(!isset($this->fonts[$fontkey])) 	{
			// STANDARD CORE FONTS
			if (isset($this->CoreFonts[$fontkey])) {
				//Load metric file
				$file=$family;
				if($family=='ctimes' || $family=='chelvetica' || $family=='ccourier') { $file.=strtolower($style); }
				$file.='.php';
				include(_MPDF_PATH.'font/'.$file);
				if(!isset($cw)) { $this->Error('Could not include font metric file'); }
				$i=count($this->fonts)+$this->extraFontSubsets+1;
				$this->fonts[$fontkey]=array('i'=>$i,'type'=>'core','name'=>$this->CoreFonts[$fontkey],'desc'=>$desc,'up'=>$up,'ut'=>$ut,'cw'=>$cw);
			}
			else {
				die('mPDF error - Font not defined');
			}
		}
		//Test if font is already selected
		if(($this->FontFamily == $family) AND ($this->FontStyle == $style) AND ($this->FontSizePt == $size) && !$forcewrite) {
			return $family;
		}
		//Select it
		$this->FontFamily=$family;
		$this->FontStyle=$style;
		$this->FontSizePt=$size;
		$this->FontSize=$size/$this->k;
		$this->CurrentFont=&$this->fonts[$fontkey];
		if ($write) { 
			$fontout = (sprintf('BT /F%d %.3f Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
			if($this->page>0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']) || $this->keep_block_together)) { $this->_out($fontout); }
			$this->pageoutput[$this->page]['Font'] = $fontout;
		}
		// Added - currentfont (lowercase) used in HTML2PDF
		$this->currentfontfamily=$family;
		$this->currentfontsize=$size;
		$this->currentfontstyle=$style.($this->U ? 'U' : '').($this->S ? 'S' : '');

	}

	return $family;
}

function SetFontSize($size,$write=true) {
	//Set font size in points
	if($this->FontSizePt==$size) return;
	$this->FontSizePt=$size;
	$this->FontSize=$size/$this->k;
	$this->currentfontsize=$size;
		if ($write) { 
			$fontout = (sprintf('BT /F%d %.3f Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
			// Edited mPDF 3.0
			if($this->page>0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']) || $this->keep_block_together)) { $this->_out($fontout); }
			$this->pageoutput[$this->page]['Font'] = $fontout;
		}
}

function AddLink() {
	//Create a new internal link
	$n=count($this->links)+1;
	$this->links[$n]=array(0,0);
	return $n;
}

function SetLink($link,$y=0,$page=-1) {
	//Set destination of internal link
	if($y==-1) $y=$this->y;
	if($page==-1)	$page=$this->page;
	$this->links[$link]=array($page,$y);
}

function Link($x,$y,$w,$h,$link) {
	if ($this->keep_block_together) {	// Save to array - don't write yet
		$this->ktLinks[$this->page][]=array($x*$this->k,$this->hPt-$y*$this->k,$w*$this->k,$h*$this->k,$link);
		return;
	}
	else if ($this->kwt) {
		$this->kwt_Links[$this->page][]=array($x*$this->k,$this->hPt-$y*$this->k,$w*$this->k,$h*$this->k,$link);
		return;
	}

	if ($this->writingHTMLheader || $this->writingHTMLfooter) {
		$this->HTMLheaderPageLinks[]=array($x*$this->k,$this->hPt-$y*$this->k,$w*$this->k,$h*$this->k,$link);
		return;
	}
	//Put a link on the page
	$this->PageLinks[$this->page][]=array($x*$this->k,$this->hPt-$y*$this->k,$w*$this->k,$h*$this->k,$link);
	// Save cross-reference to Column buffer

}

function Text($x,$y,$txt) {
	// Output a string
	// Called (internally) by Watermark and _tableWrite [rotated cells]
	// Expects input to be mb_encoded if necessary and RTL reversed

	// mPDF 5.0 ARTIFICIAL BOLD AND ITALIC
	$s = 'q ';
	if ($this->falseBoldWeight && strpos($this->ReqFontStyle,"B") !== false && strpos($this->FontStyle,"B") === false) {
		$s  .= '2 Tr 1 J 1 j ';
		$s .= sprintf('%.3f w ',($this->FontSize/130)*$this->k*$this->falseBoldWeight);
		$tc = strtoupper($this->TextColor); // change 0 0 0 rg to 0 0 0 RG
		if($this->FillColor!=$tc) { $s .= $tc.' '; }		// stroke (outline) = same colour as text(fill)
	}
	if (strpos($this->ReqFontStyle,"I") !== false && strpos($this->FontStyle,"I") === false) {
		$aix = '1 0 0.261799 1 %.3f %.3f Tm'; 
	}
	else { $aix = '%.3f %.3f Td'; }

	if($this->ColorFlag) $s.=$this->TextColor.' ';

	$this->CurrentFont['used']= true;
	if ($this->CurrentFont['type']=='TTF' && ($this->CurrentFont['sip'] || $this->CurrentFont['smp'])) {	// mPDF 5.0.03 Added SMP
	      $txt2 = str_replace($this->chrs[194].$this->chrs[160],$this->chrs[32],$txt);	// mPDF 5.0
		$txt2 = $this->UTF8toSubset($txt2);
		$s.=sprintf('BT '.$aix.' %s Tj ET ',$x*$this->k,($this->h-$y)*$this->k,$txt2);
	}
	else if (!$this->onlyCoreFonts && !$this->usingCoreFont) {
	      $txt2 = str_replace($this->chrs[194].$this->chrs[160],$this->chrs[32],$txt); 
		$this->UTF8StringToArray($txt2);	// mPDF 5.0 this is just to add chars to subset list
		//Convert string to UTF-16BE without BOM
		$txt2= $this->UTF8ToUTF16BE($txt2, false);
		$s.=sprintf('BT '.$aix.' (%s) Tj ET ',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt2));
	}
	else {
	      $txt2 = str_replace($this->chrs[160],$this->chrs[32],$txt);
		$s.=sprintf('BT '.$aix.' (%s) Tj ET ',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt2));
	}
	if($this->U and $txt!='') {
		$s.=$this->_dounderline($x,$y + (0.1* $this->FontSize),$txt).' ';
	}
	$s .= 'Q';
	$this->_out($s);
}



function ResetSpacing() {
	if ($this->ws != 0) { $this->_out('BT 0 Tw ET'); }
	$this->ws=0;
	if ($this->charspacing != 0) { $this->_out('BT 0 Tc ET'); }
	$this->charspacing=0;
}


function SetSpacing($cs,$ws) {
	if ($cs) { $this->_out(sprintf('BT %.3f Tc ET',$cs)); }
	else if ($this->charspacing != 0) { $this->_out('BT 0 Tc ET'); }
	$this->charspacing=$cs;
	if ($ws) { $this->_out(sprintf('BT %.3f Tw ET',$ws)); }
	else if ($this->ws != 0) { $this->_out('BT 0 Tw ET'); }
	$this->ws=$ws;
}

// WORD SPACING
function GetJspacing($nc,$ns,$w) {
	$ws = 0; 
	$charspacing = 0;
	$ww = $this->jSWord;
	$ncx = $nc-1;
	if ($nc == 0 && $ns == 0) { return array(0,0); }
	if ($nc==1) { $charspacing = $w; }
	else if ($this->jSpacing == 'C') {
		if ($nc) { $charspacing = $w / ($ncx ); }
	}
	else if ($this->jSpacing == 'W') {
		if ($ns) { $ws = $w / $ns; }
	}
	else if (!$ns) {
		if ($nc) { $charspacing = $w / ($ncx ); }
		if (($this->jSmaxChar > 0) && ($charspacing > $this->jSmaxChar)) { 
			$charspacing = $this->jSmaxChar;
		}
	}
	else if ($ns == ($ncx )) {
		$charspacing = $w / $ns;
	}
	else {
		if ($nc) { 
		   if ($this->usingCoreFont) {
			$cs = ($w * (1 - $this->jSWord)) / ($ncx );
			if (($this->jSmaxChar > 0) && ($cs > $this->jSmaxChar)) {
				$cs = $this->jSmaxChar;
				$ww = 1 - (($cs * ($ncx ))/$w);
			}
			$charspacing = $cs; 
			$ws = ($w * ($ww) ) / $ns;
		   }
		   else {
			$cs = ($w * (1 - $this->jSWord)) / ($ncx -$ns);			if (($this->jSmaxChar > 0) && ($cs > $this->jSmaxChar)) {
				$cs = $this->jSmaxChar;
				$ww = 1 - (($cs * ($ncx -$ns))/$w);
			}
			$charspacing = $cs; 
			$ws = (($w * ($ww) ) / $ns) - $charspacing;
		   }
		}
	}
	return array($charspacing,$ws); 
}

function Cell($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='', $currentx=0, $lcpaddingL=0, $lcpaddingR=0, $valign='M', $spanfill=0, $abovefont=0, $belowfont=0) {
	//Output a cell
	// Expects input to be mb_encoded if necessary and RTL reversed
	// NON_BREAKING SPACE
	if ($this->usingCoreFont) {
	      $txt = str_replace($this->chrs[160],$this->chrs[32],$txt);
	}
	else {
	      $txt = str_replace($this->chrs[194].$this->chrs[160],$this->chrs[32],$txt);
	}

	$k=$this->k;
	$oldcolumn = $this->CurrCol;
	// Automatic page break
	// Allows PAGE-BREAK-AFTER = avoid to work

	if (!$this->tableLevel && (($this->y+$this->divheight>$this->PageBreakTrigger) || ($this->y+$h>$this->PageBreakTrigger) || 
		($this->y+($h*2)>$this->PageBreakTrigger && $this->blk[$this->blklvl]['page_break_after_avoid'])) and !$this->InFooter and $this->AcceptPageBreak()) {
		$x=$this->x;//Current X position


		// WORD SPACING
		$ws=$this->ws;//Word Spacing
		$charspacing=$this->charspacing;//Character Spacing
		$this->ResetSpacing();

		$this->AddPage($this->CurOrientation);
		// Added to correct for OddEven Margins
		$x += $this->MarginCorrection;
		if ($currentx) { 
			$currentx += $this->MarginCorrection;
		} 
		$this->x=$x;
		// WORD SPACING
		$this->SetSpacing($charspacing,$ws);
	}

	// Test: to put border round each cell: $border=1;
	// Test: to put line through centre of cell: $this->Line($this->x,$this->y+($h/2),$this->x+50,$this->y+($h/2));


	// KEEP BLOCK TOGETHER Update/overwrite the lowest bottom of printing y value on first page
	if ($this->keep_block_together) {
		if ($h) { $this->ktBlock[$this->page]['bottom_margin'] = $this->y+$h; }
//		else { $this->ktBlock[$this->page]['bottom_margin'] = $this->y+$this->divheight; }
	}

	if($w==0) $w = $this->w-$this->rMargin-$this->x;
	$s='';
	if($fill==1 && $this->FillColor) { 
		if((isset($this->pageoutput[$this->page]['FillColor']) && $this->pageoutput[$this->page]['FillColor'] != $this->FillColor) || !isset($this->pageoutput[$this->page]['FillColor']) || $this->keep_block_together) { $s .= $this->FillColor.' '; }
		$this->pageoutput[$this->page]['FillColor'] = $this->FillColor;
	}


	$boxtop = $this->y;
	$boxheight = $h;
	$boxbottom = $this->y+$h;

	if($txt!='') {
		// FONT SIZE - this determines the baseline caculation
		if ($this->linemaxfontsize && !$this->processingHeader) { $bfs = $this->linemaxfontsize; }
		else  { $bfs = $this->FontSize; }
    		//Calculate baseline Superscript and Subscript Y coordinate adjustment
		$bfx = $this->baselineC;
    		$baseline = $bfx*$bfs;
		if($this->SUP) { $baseline += ($bfx-1.05)*$this->FontSize; }
		else if($this->SUB) { $baseline += ($bfx + 0.04)*$this->FontSize; }
		else if($this->bullet) { $baseline += ($bfx-0.7)*$this->FontSize; }

		// Vertical align (for Images)
		if ($abovefont || $belowfont) {	// from flowing block - valign always M
			$va = $abovefont + (0.5*$bfs);
		}
		else if ($this->lineheight_correction) { 
			if ($valign == 'T') { $va = (0.5 * $bfs * $this->lineheight_correction); }
			else if ($valign == 'B') { $va = $h-(0.5 * $bfs * $this->lineheight_correction); }
			else { $va = 0.5*$h; }	// Middle
		}
		else { 
			if ($valign == 'T') { $va = (0.5 * $bfs * $this->default_lineheight_correction); }
			else if ($valign == 'B') { $va = $h-(0.5 * $bfs * $this->default_lineheight_correction); }
			else { $va = 0.5*$h; }	// Middle
		}

		// ONLY SET THESE IF WANT TO CONFINE BORDER +- FILL TO FIT FONTSIZE - NOT FULL CELL
		if ($spanfill) {
			$boxtop = $this->y+$baseline+$va-($this->FontSize*(0.5+$bfx));
			$boxheight = $this->FontSize;
			$boxbottom = $boxtop + $boxheight;
		}
	}


	if($fill==1 or $border==1) {
		if ($fill==1) $op=($border==1) ? 'B' : 'f';
		else $op='S';
		$s.=sprintf('%.3f %.3f %.3f %.3f re %s ',$this->x*$k,($this->h-$boxtop)*$k,$w*$k,-$boxheight*$k,$op);
	}

	if(is_string($border)) {
		$x=$this->x;
		$y=$this->y;
		if(is_int(strpos($border,'L')))
			$s.=sprintf('%.3f %.3f m %.3f %.3f l S ',$x*$k,($this->h-$boxtop)*$k,$x*$k,($this->h-($boxbottom))*$k);
		if(is_int(strpos($border,'T')))
			$s.=sprintf('%.3f %.3f m %.3f %.3f l S ',$x*$k,($this->h-$boxtop)*$k,($x+$w)*$k,($this->h-$boxtop)*$k);
		if(is_int(strpos($border,'R')))
			$s.=sprintf('%.3f %.3f m %.3f %.3f l S ',($x+$w)*$k,($this->h-$boxtop)*$k,($x+$w)*$k,($this->h-($boxbottom))*$k);
		if(is_int(strpos($border,'B')))
			$s.=sprintf('%.3f %.3f m %.3f %.3f l S ',$x*$k,($this->h-($boxbottom))*$k,($x+$w)*$k,($this->h-($boxbottom))*$k);
	}

	if($txt!='') {
		$stringWidth = $this->GetStringWidth($txt) + ( $this->charspacing * mb_strlen( $txt, $this->mb_enc ) / $k )
				 + ( $this->ws * mb_substr_count( $txt, ' ', $this->mb_enc ) / $k );

		// Set x OFFSET FOR PRINTING
		if($align=='R') {
			$dx=$w-$this->cMarginR - $stringWidth - $lcpaddingR;
		}
		elseif($align=='C') {
			$dx=(($w - $stringWidth )/2);
		}
		elseif($align=='L' or $align=='J') $dx=$this->cMarginL + $lcpaddingL;
    		else $dx = 0;

		if($this->ColorFlag) $s.='q '.$this->TextColor.' ';

		// OUTLINE
		if($this->outline_on && !$this->S) {
			$s.=' '.sprintf('%.3f w',$this->LineWidth*$k).' ';
			$s.=" $this->DrawColor ";
			$s.=" 2 Tr ";
    		}
		else if ($this->falseBoldWeight && strpos($this->ReqFontStyle,"B") !== false && strpos($this->FontStyle,"B") === false && !$this->S) {	// can't use together with OUTLINE or Small Caps
			$s  .= ' 2 Tr 1 J 1 j ';
			$s .= ' '.sprintf('%.3f w',($this->FontSize/130)*$k*$this->falseBoldWeight).' ';
			$tc = strtoupper($this->TextColor); // change 0 0 0 rg to 0 0 0 RG
			if($this->FillColor!=$tc) { $s .= ' '.$tc.' '; }		// stroke (outline) = same colour as text(fill)
		}

		if (strpos($this->ReqFontStyle,"I") !== false && strpos($this->FontStyle,"I") === false) {	// Artificial italic
			$aix = '1 0 0.261799 1 %.3f %.3f Tm '; 
		}
		else { $aix = '%.3f %.3f Td '; }

		// THE TEXT
		$this->CurrentFont['used']= true;

		// WORD SPACING
		// IF multibyte - Tw has no effect - need to do word spacing by setting character spacing for spaces between words
		if ($this->ws && !$this->usingCoreFont && !$this->CurrentFont['sip'] && !$this->CurrentFont['smp'] && !$this->S) {	// mPDF 5.0.03
		  $space = ' ';
		  //Convert string to UTF-16BE without BOM
		  $space= $this->UTF8ToUTF16BE($space , false);
		  $space=$this->_escape($space ); 
		  $s.=sprintf('BT '.$aix,($this->x+$dx)*$k,($this->h-($this->y+$baseline+$va))*$k);
		  $t = explode(' ',$txt);
		  for($i=0;$i<count($t);$i++) {
			$tx = $t[$i]; 
			//Convert string to UTF-16BE without BOM
			$tx = $this->UTF8ToUTF16BE($tx , false);
			$tx = $this->_escape($tx); 
			$s.=sprintf(' %.3f Tc (%s) Tj',$this->charspacing,$tx);
			if (($i+1)<count($t)) {
				$s.=sprintf(' %.3f Tc (%s) Tj',$this->ws+$this->charspacing,$space);
			}
		  }
		  $s.=' ET';
		}
		else {
		  $txt2= $txt;
		  if ($this->CurrentFont['type']=='TTF' && ($this->CurrentFont['sip'] || $this->CurrentFont['smp'])) {	// mPDF 5.0.03 Added SMP
			if ($this->S) { $s .= $this->_smallCaps($txt2, 'SIPSMP', $aix, $dx, $k, $baseline, $va, $space); } 
			else {
				$txt2 = $this->UTF8toSubset($txt2);
				$s.=sprintf('BT '.$aix.' %s Tj ET',($this->x+$dx)*$k,($this->h-($this->y+$baseline+$va))*$k,$txt2);
			}
		  }
		  else {
			if ($this->S) { $s .= $this->_smallCaps($txt2, '', $aix, $dx, $k, $baseline, $va, $space); } 
			else {
				if (!$this->usingCoreFont) {
					$txt2 = $this->UTF8ToUTF16BE($txt2, false);
				}
				$txt2=$this->_escape($txt2); 
				$s.=sprintf('BT '.$aix.' (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+$baseline+$va))*$k,$txt2);
			}
		  }
		}
		// UNDERLINE
		if($this->U) {
			$c = strtoupper($this->TextColor); // change 0 0 0 rg to 0 0 0 RG
			if($this->FillColor!=$c) { $s.= ' '.$c.' '; }
			if (isset($this->CurrentFont['up'])) { $up=$this->CurrentFont['up']; }
			else { $up = -100; }
			$adjusty = (-$up/1000* $this->FontSize);
 			if (isset($this->CurrentFont['ut'])) { $ut=$this->CurrentFont['ut']/1000* $this->FontSize; }
			else { $ut = 60/1000* $this->FontSize; }
			$olw = $this->LineWidth;
			$s.=' '.(sprintf(' %.3f w',$ut*$this->k));
			$s.=' '.$this->_dounderline($this->x+$dx,$this->y+$baseline+$va+$adjusty,$txt);
			$s.=' '.(sprintf(' %.3f w',$olw*$this->k));
			if($this->FillColor!=$c) { $s.= ' '.$this->FillColor.' '; }
		}

   		// STRIKETHROUGH
		if($this->strike) {
			$c = strtoupper($this->TextColor); // change 0 0 0 rg to 0 0 0 RG
			if($this->FillColor!=$c) { $s.= ' '.$c.' '; }
    			//Superscript and Subscript Y coordinate adjustment (now for striked-through texts)
			if (isset($this->CurrentFont['desc']['CapHeight'])) { $ch=$this->CurrentFont['desc']['CapHeight']; }
			else { $ch = 700; }
			$adjusty = (-$ch/1000* $this->FontSize) * 0.35;
 			if (isset($this->CurrentFont['ut'])) { $ut=$this->CurrentFont['ut']/1000* $this->FontSize; }
			else { $ut = 60/1000* $this->FontSize; }
			$olw = $this->LineWidth;
			$s.=' '.(sprintf(' %.3f w',$ut*$this->k));
			$s.=' '.$this->_dounderline($this->x+$dx,$this->y+$baseline+$va+$adjusty,$txt);
			$s.=' '.(sprintf(' %.3f w',$olw));
			if($this->FillColor!=$c) { $s.= ' '.$this->FillColor.' '; }
		}

		// COLOR
		if($this->ColorFlag) $s.=' Q';

		// LINK
		if($link!='') {
			$this->Link($this->x+$dx,$this->y+$va-.5*$this->FontSize,$stringWidth,$this->FontSize,$link);
		}
	}
	if($s) $this->_out($s);

	// WORD SPACING
	if ($this->ws && !$this->usingCoreFont) {
		$this->_out(sprintf('BT %.3f Tc ET',$this->charspacing));	 
	}
	$this->lasth=$h;
	if( strpos($txt,"\n") !== false) $ln=1; // cell recognizes \n from <BR> tag
	if($ln>0)
	{
		//Go to next line
		$this->y += $h;
		if($ln==1) {
			//Move to next line
			if ($currentx != 0) { $this->x=$currentx; }
			else { $this->x=$this->lMargin; }
   		}
	}
	else $this->x+=$w;


}



function _smallCaps($txt, $mode, $aix, $dx, $k, $baseline, $va, $space) {
	$upp = false;
	$str = array();
	$bits = array();
	if (!$this->usingCoreFont) { 
	   $unicode = $this->UTF8StringToArray($txt);
	   foreach($unicode as $char) {
		if (isset($this->upperCase[$char])) { 
			if (!$upp) { 
				if (count($str)) { $bits[] = array($upp, $str); }
				$str = array(); 
			}
			$str[] = $this->upperCase[$char]; 
			if ((!isset($this->CurrentFont['sip']) || !$this->CurrentFont['sip']) && (!isset($this->CurrentFont['smp']) || !$this->CurrentFont['smp'])) {	
				$this->CurrentFont['subset'][$this->upperCase[$char]] = $this->upperCase[$char];
			}
			$upp = true;
		}
		else { 
			if ($upp) { 
				if (count($str)) { $bits[] = array($upp, $str); }
				$str = array(); 
			}
			$str[] = $char;
			$upp = false;
		}
	   }
	}
	else {
	   for($i=0;$i<strlen($txt);$i++) {
		if (isset($this->upperCase[ord($txt[$i])]) && $this->upperCase[ord($txt[$i])] < 256) { 
			if (!$upp) { 
				if (count($str)) { $bits[] = array($upp, $str); }
				$str = array(); 
			}
			$str[] = $this->upperCase[ord($txt[$i])]; 
			$upp = true;
		}
		else { 
			if ($upp) { 
				if (count($str)) { $bits[] = array($upp, $str); }
				$str = array(); 
			}
			$str[] = ord($txt[$i]);
			$upp = false;
		}
	   }
	}
	if (count($str)) { $bits[] = array($upp, $str); }

	$fid = $this->CurrentFont['i'];

	$s.=sprintf(' BT '.$aix,($this->x+$dx)*$k,($this->h-($this->y+$baseline+$va))*$k);
	foreach($bits AS $b) {
		if ($b[0]) { $upp = true; }
		else { $upp = false; }

		$size = count ($b[1]);
		$txt = '';
		for ($i = 0; $i < $size; $i++) {
			$txt .= code2utf($b[1][$i]); 
		}
		if ($this->usingCoreFont) { 
			$txt = utf8_decode($txt);
		}
		if ($mode == 'SIPSMP') {
			$txt = $this->UTF8toSubset($txt);
			if ($upp) { $s.=sprintf(' /F%d %.3f Tf %d Tz', $fid, $this->FontSizePt*$this->smCapsScale, $this->smCapsStretch); }
			else { $s.=sprintf(' /F%d %.3f Tf %d Tz', $fid, $this->FontSizePt, 100); }
			$s.=sprintf(' %s Tj', $txt);
		}
		else { 
			if (!$this->usingCoreFont) {
				$txt = $this->UTF8ToUTF16BE($txt, false);
			}
			$txt=$this->_escape($txt); 
			if ($upp) { $s.=sprintf(' /F%d %.3f Tf %d Tz', $fid, $this->FontSizePt*$this->smCapsScale, $this->smCapsStretch); }
			else { $s.=sprintf(' /F%d %.3f Tf %d Tz', $fid, $this->FontSizePt, 100); }
			$s.=sprintf(' (%s) Tj', $txt);
		}
	}
	$s.=' ET ';
	return $s;
}


function MultiCell($w,$h,$txt,$border=0,$align='',$fill=0,$link='',$directionality='ltr',$encoded=false)
{
	// Parameter (pre-)encoded - When called internally from ToC or textarea: mb_encoding already done - but not reverse RTL/Indic
	if (!$encoded) {
		$txt = $this->purify_utf8_text($txt);
		if ($this->text_input_as_HTML) {
			$txt = $this->all_entities_to_utf8($txt);
		}
		if ($this->usingCoreFont) { $txt = mb_convert_encoding($txt,$this->mb_enc,'UTF-8'); }
		// Font-specific ligature substitution for Indic fonts
	}
	if (!$align) { $align = $this->defaultAlign; }
	//Output text with automatic or explicit line breaks
	$cw=&$this->CurrentFont['cw'];
	if($w==0)	$w=$this->w-$this->rMargin-$this->x;

	$wmax = ($w - ($this->cMarginL+$this->cMarginR));	// mPDF 5.0
	if ($this->usingCoreFont)  {
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		while($nb>0 and $s[$nb-1]=="\n")	$nb--;
	}
	else {
		$s=str_replace("\r",'',$txt);
		$nb=mb_strlen($s, $this->mb_enc );
		while($nb>0 and mb_substr($s,$nb-1,1,$this->mb_enc )=="\n")	$nb--;
	}
	$b=0;
	if($border) {
		if($border==1) {
			$border='LTRB';
			$b='LRT';
			$b2='LR';
		}
		else {
			$b2='';
			if(is_int(strpos($border,'L')))	$b2.='L';
			if(is_int(strpos($border,'R')))	$b2.='R';
			$b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
		}
	}
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$ns=0;
	$nl=1;



   if (!$this->usingCoreFont)  {
	while($i<$nb) {
		//Get next character
		$c = mb_substr($s,$i,1,$this->mb_enc );
		if($c == "\n") {
			//Explicit line break
			// WORD SPACING
			$this->ResetSpacing();
			$tmp = rtrim(mb_substr($s,$j,$i-$j,$this->mb_enc));
			// DIRECTIONALITY

			$this->Cell($w,$h,$tmp,$b,2,$align,$fill,$link);
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border and $nl==2) $b=$b2;
			continue;
		}
		if($c == " ") {
			$sep=$i;
			$ls=$l;
			$ns++;
		}

		$l = $this->GetStringWidth(mb_substr($s, $j, $i-$j,$this->mb_enc ));

		if($l>$wmax) {
			//Automatic line break
			if($sep==-1) {	// Only one word
				if($i==$j) $i++;
				// WORD SPACING
				$this->ResetSpacing();
				$tmp = rtrim(mb_substr($s,$j,$i-$j,$this->mb_enc));
				// DIRECTIONALITY

				$this->Cell($w,$h,$tmp,$b,2,$align,$fill,$link);
			}
			else {
				$tmp = rtrim(mb_substr($s,$j,$sep-$j,$this->mb_enc));
				if($align=='J') {
					//$this->ws=($ns>1) ? ((($wmax-$ls)/($ns-1))) : 0;
					//$this->_out(sprintf('%.3f Tw',$this->ws*$this->k));

					//////////////////////////////////////////
					// JUSTIFY J using Unicode fonts (Word spacing doesn't work)
					// WORD SPACING UNICODE
					// Change NON_BREAKING SPACE to spaces so they are 'spaced' properly
					$tmp = str_replace($this->chrs[194].$this->chrs[160],$this->chrs[32],$tmp ); 
					$len_ligne = $this->GetStringWidth($tmp );
					$nb_carac = mb_strlen( $tmp , $this->mb_enc ) ;  
					$nb_spaces = mb_substr_count( $tmp ,' ', $this->mb_enc ) ;  
					list($charspacing,$ws) = $this->GetJspacing($nb_carac,$nb_spaces,((($w-2) - $len_ligne) * $this->k));
					$this->SetSpacing($charspacing,$ws);
					//////////////////////////////////////////
				}

				// DIRECTIONALITY

				$this->Cell($w,$h,$tmp,$b,2,$align,$fill,$link);
				$i=$sep+1;
			}
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border and $nl==2) $b=$b2;
		}
		else $i++;
	}
	//Last chunk
	// WORD SPACING

	$this->ResetSpacing();

   }


   else {

	while($i<$nb) {
		//Get next character
		$c=$s[$i];
		if($c == "\n") {
			//Explicit line break
			// WORD SPACING
			$this->ResetSpacing();
			$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill,$link);
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border and $nl==2) $b=$b2;
			continue;
		}
		if($c == " ") {
			$sep=$i;
			$ls=$l;
			$ns++;
		}

		$l += $this->GetStringWidth($c);
		if($l>$wmax) {
			//Automatic line break
			if($sep==-1) {
				if($i==$j) $i++;
				// WORD SPACING
				$this->ResetSpacing();
				$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill,$link);
			}
			else {
				if($align=='J') {
					$tmp = rtrim(substr($s,$j,$sep-$j));
					//////////////////////////////////////////
					// JUSTIFY J using Unicode fonts (Word spacing doesn't work)
					// WORD SPACING NON_UNICDOE/CJK
					// Change NON_BREAKING SPACE to spaces so they are 'spaced' properly
					$tmp = str_replace($this->chrs[160],$this->chrs[32],$tmp);
					$len_ligne = $this->GetStringWidth($tmp );
					$nb_carac = strlen( $tmp ) ;  
					$nb_spaces = substr_count( $tmp ,' ' ) ;  
					list($charspacing,$ws) = $this->GetJspacing($nb_carac,$nb_spaces,((($w-2) - $len_ligne) * $this->k));
					$this->SetSpacing($charspacing,$ws);
					//////////////////////////////////////////
				}
				$this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill,$link);
				$i=$sep+1;
			}
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border and $nl==2) $b=$b2;
		}
		else $i++;
	}
	//Last chunk
	// WORD SPACING

	$this->ResetSpacing();

   }
	//Last chunk
   if($border and is_int(strpos($border,'B')))	$b.='B';
   if (!$this->usingCoreFont)  {
		$tmp = rtrim(mb_substr($s,$j,$i-$j,$this->mb_enc));
		// DIRECTIONALITY
   		$this->Cell($w,$h,$tmp,$b,2,$align,$fill,$link);
   }
   else { $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill,$link); }
   $this->x=$this->lMargin;
}




function saveInlineProperties() {
   $saved = array();
   $saved[ 'family' ] = $this->FontFamily;
   $saved[ 'style' ] = $this->FontStyle;
   $saved[ 'sizePt' ] = $this->FontSizePt;
   $saved[ 'size' ] = $this->FontSize;
   $saved[ 'HREF' ] = $this->HREF; 
   $saved[ 'underline' ] = $this->U; 
   $saved[ 'smCaps' ] = $this->S; 	// mPDF 5.0
   $saved[ 'strike' ] = $this->strike;
   $saved[ 'SUP' ] = $this->SUP; 
   $saved[ 'SUB' ] = $this->SUB; 
   $saved[ 'linewidth' ] = $this->LineWidth;
   $saved[ 'drawcolor' ] = $this->DrawColor;
   $saved[ 'is_outline' ] = $this->outline_on;
   $saved[ 'outlineparam' ] = $this->outlineparam;
   $saved[ 'toupper' ] = $this->toupper;
   $saved[ 'tolower' ] = $this->tolower;
   $saved[ 'I' ] = $this->I;
   $saved[ 'B' ] = $this->B;
   $saved[ 'colorarray' ] = $this->colorarray;
   $saved[ 'bgcolorarray' ] = $this->spanbgcolorarray;
   $saved[ 'color' ] = $this->TextColor; 
   $saved[ 'bgcolor' ] = $this->FillColor;
   $saved['lang'] = $this->currentLang;
   $saved['display_off'] = $this->inlineDisplayOff;	// mPDF 5.0

   return $saved;
}

function restoreInlineProperties( &$saved) {
   $FontFamily = $saved[ 'family' ];
   $this->FontStyle = $saved[ 'style' ];
   $this->FontSizePt = $saved[ 'sizePt' ];
   $this->FontSize = $saved[ 'size' ];

   $this->currentLang =  $saved['lang'];
   if ($this->useLang && !$this->usingCoreFont) {
	if ($this->currentLang != $this->default_lang && ((strlen($this->currentLang) == 5 && $this->currentLang != 'UTF-8') || strlen($this->currentLang ) == 2)) { 
		list ($coreSuitable,$mpdf_pdf_unifonts,$mpdf_directionality,$mpdf_jSpacing) = GetLangOpts($this->currentLang, $this->useAdobeCJK);
		if ($mpdf_pdf_unifonts) { $this->RestrictUnicodeFonts($mpdf_pdf_unifonts); }
		else { $this->RestrictUnicodeFonts($this->default_available_fonts ); }
   	}
   	else { 
		$this->RestrictUnicodeFonts($this->default_available_fonts );
	} 
   }

   $this->ColorFlag = ($this->FillColor != $this->TextColor); //Restore ColorFlag as well

   $this->HREF = $saved[ 'HREF' ];
   $this->U = $saved[ 'underline' ];
   $this->S = $saved[ 'smCaps' ];	// mPDF 5.0 
   $this->strike = $saved[ 'strike' ];
   $this->SUP = $saved[ 'SUP' ];
   $this->SUB = $saved[ 'SUB' ];
   $this->LineWidth = $saved[ 'linewidth' ];
   $this->DrawColor = $saved[ 'drawcolor' ];
   $this->outline_on = $saved[ 'is_outline' ];
   $this->outlineparam = $saved[ 'outlineparam' ];
   $this->inlineDisplayOff = $saved['display_off'];	// mPDF 5.0

   $this->toupper = $saved[ 'toupper' ];
   $this->tolower = $saved[ 'tolower' ];

   
   $this->SetFont($FontFamily, $saved[ 'style' ].($this->U ? 'U' : '').($this->S ? 'S' : ''),$saved[ 'sizePt' ],false);
   //$this->currentfontfamily = $saved[ 'family' ];

   $this->currentfontstyle = $saved[ 'style' ].($this->U ? 'U' : '').($this->S ? 'S' : '');
   $this->currentfontsize = $saved[ 'sizePt' ];
   $this->SetStylesArray(array('S'=>$this->S, 'U'=>$this->U, 'B'=>$saved[ 'B' ], 'I'=>$saved[ 'I' ]));	// mPDF 5.0

   $this->TextColor = $saved[ 'color' ];
   $this->FillColor = $saved[ 'bgcolor' ];
   $this->colorarray = $saved[ 'colorarray' ];
   	$cor = $saved[ 'colorarray' ];
   	if ($cor) $this->SetTextColor($cor['R'],$cor['G'],$cor['B']);
   $this->spanbgcolorarray = $saved[ 'bgcolorarray' ];
   	$cor = $saved[ 'bgcolorarray' ];
   	if ($cor) $this->SetFillColor($cor['R'],$cor['G'],$cor['B']);
}



// Used when ColActive for tables - updated to return first block with background fill OR borders
function GetFirstBlockFill() {
	// Returns the first blocklevel that uses a bgcolor fill
	$startfill = 0;
	for ($i=1;$i<=$this->blklvl;$i++) {
		if ($this->blk[$i]['bgcolor'] || $this->blk[$i]['border_left']['w'] || $this->blk[$i]['border_right']['w']  || $this->blk[$i]['border_top']['w']  || $this->blk[$i]['border_bottom']['w']  ) {
			$startfill = $i;
			break;
		}
	}
	return $startfill;
}

function SetBlockFill($blvl) {
	if ($this->blk[$blvl]['bgcolor']) {
		$this->SetFillColor($this->blk[$blvl]['bgcolorarray']['R'],$this->blk[$blvl]['bgcolorarray']['G'],$this->blk[$blvl]['bgcolorarray']['B']);
		return 1;
	}
	else {
		$this->SetFillColor(255);
		return 0;
	}
}


//-------------------------FLOWING BLOCK------------------------------------//
//The following functions were originally written by Damon Kohler           //
//--------------------------------------------------------------------------//

function saveFont() {
   $saved = array();
   $saved[ 'family' ] = $this->FontFamily;
   $saved[ 'style' ] = $this->FontStyle;
   $saved[ 'sizePt' ] = $this->FontSizePt;
   $saved[ 'size' ] = $this->FontSize;
   $saved[ 'curr' ] = &$this->CurrentFont;
   $saved[ 'color' ] = $this->TextColor; 
   $saved[ 'spanbgcolor' ] = $this->spanbgcolor; 
   $saved[ 'spanbgcolorarray' ] = $this->spanbgcolorarray; 
   $saved[ 'HREF' ] = $this->HREF;
   $saved[ 'underline' ] = $this->U; 
   $saved[ 'smCaps' ] = $this->S; 	// mPDF 5.0
   $saved[ 'strike' ] = $this->strike;
   $saved[ 'SUP' ] = $this->SUP;
   $saved[ 'SUB' ] = $this->SUB;
   $saved[ 'linewidth' ] = $this->LineWidth;
   $saved[ 'drawcolor' ] = $this->DrawColor;
   $saved[ 'is_outline' ] = $this->outline_on;
   $saved[ 'outlineparam' ] = $this->outlineparam;
   $saved[ 'ReqFontStyle' ] = $this->ReqFontStyle;
   return $saved;
}

function restoreFont( &$saved, $write=true) {
   if (!isset($saved) || empty($saved)) return;

   $this->FontFamily = $saved[ 'family' ];
   $this->FontStyle = $saved[ 'style' ];
   $this->FontSizePt = $saved[ 'sizePt' ];
   $this->FontSize = $saved[ 'size' ];
   $this->CurrentFont = &$saved[ 'curr' ];
   $this->TextColor = $saved[ 'color' ]; 
   $this->spanbgcolor = $saved[ 'spanbgcolor' ]; 
   $this->spanbgcolorarray = $saved[ 'spanbgcolorarray' ]; 
   $this->ColorFlag = ($this->FillColor != $this->TextColor); //Restore ColorFlag as well
   $this->HREF = $saved[ 'HREF' ]; 
   $this->U = $saved[ 'underline' ]; 
   $this->S = $saved[ 'smCaps' ]; 	// mPDF 5.0
   $this->strike = $saved[ 'strike' ]; 
   $this->SUP = $saved[ 'SUP' ]; 
   $this->SUB = $saved[ 'SUB' ]; 
   $this->LineWidth = $saved[ 'linewidth' ]; 
   $this->DrawColor = $saved[ 'drawcolor' ]; 
   $this->outline_on = $saved[ 'is_outline' ]; 
   $this->outlineparam = $saved[ 'outlineparam' ];
   if ($write) { 
   	$this->SetFont($saved[ 'family' ],$saved[ 'style' ].($this->U ? 'U' : '').($this->S ? 'S' : ''),$saved[ 'sizePt' ],true,true);	// force output
	$fontout = (sprintf('BT /F%d %.3f Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
	if($this->page>0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']) || $this->keep_block_together)) { $this->_out($fontout); }
	$this->pageoutput[$this->page]['Font'] = $fontout;
   }
   else 
   	$this->SetFont($saved[ 'family' ],$saved[ 'style' ].($this->U ? 'U' : '').($this->S ? 'S' : ''),$saved[ 'sizePt' ]);
   $this->ReqFontStyle = $saved[ 'ReqFontStyle' ];
}

function newFlowingBlock( $w, $h, $a = '', $is_table = false, $is_list = false, $blockstate = 0, $newblock=true )
{
   if (!$a) { $a = $this->defaultAlign; }
   // cell width in points

   $this->flowingBlockAttr[ 'width' ] = ($w * $this->k);
   // line height in user units
   $this->flowingBlockAttr[ 'is_table' ] = $is_table;
   $this->flowingBlockAttr[ 'is_list' ] = $is_list;
   $this->flowingBlockAttr[ 'height' ] = $h;
   $this->flowingBlockAttr[ 'lineCount' ] = 0;
   $this->flowingBlockAttr[ 'align' ] = $a;
   $this->flowingBlockAttr[ 'font' ] = array();
   $this->flowingBlockAttr[ 'content' ] = array();
   $this->flowingBlockAttr[ 'contentWidth' ] = 0;
   $this->flowingBlockAttr[ 'blockstate' ] = $blockstate;

   $this->flowingBlockAttr[ 'newblock' ] = $newblock;
   $this->flowingBlockAttr[ 'valign' ] = 'M';
}

function finishFlowingBlock($endofblock=false, $next='') {
   $currentx = $this->x;
   //prints out the last chunk
   $is_table = $this->flowingBlockAttr[ 'is_table' ];
   $is_list = $this->flowingBlockAttr[ 'is_list' ];
   $maxWidth =& $this->flowingBlockAttr[ 'width' ];
   $lineHeight =& $this->flowingBlockAttr[ 'height' ];
   $align =& $this->flowingBlockAttr[ 'align' ];
   $content =& $this->flowingBlockAttr[ 'content' ];
   $font =& $this->flowingBlockAttr[ 'font' ];
   $contentWidth =& $this->flowingBlockAttr[ 'contentWidth' ];
   $lineCount =& $this->flowingBlockAttr[ 'lineCount' ];
   $valign =& $this->flowingBlockAttr[ 'valign' ];
   $blockstate = $this->flowingBlockAttr[ 'blockstate' ];

   $newblock = $this->flowingBlockAttr[ 'newblock' ];

	// *********** BLOCK BACKGROUND COLOR *****************//
	if ($this->blk[$this->blklvl]['bgcolor'] && !$is_table) {
		$fill = 0;
	}
	else {
		$this->SetFillColor(255);
		$fill = 0;
	}


	// Right trim content and adjust width if need to justify (later)
	if (!$endofblock && $align=='J' && ($next=='image' || $next=='select' || $next=='input' || $next=='textarea' || ($next=='br' && $this->justifyB4br))) {
		if (preg_match('/[ ]+$/',$content[count($content)-1], $m)) {
			$strip = strlen($m[0]);
			$content[count($content)-1] = substr($content[count($content)-1],0,(strlen($content[count($content)-1])-$strip));
			$this->restoreFont( $font[ count($content)-1 ],false );
			$contentWidth -= $this->GetStringWidth($m[0]) * $this->k;
		}
	}

	// the amount of space taken up so far in user units
	$usedWidth = 0;

	// COLS
	$oldcolumn = $this->CurrCol;


	// Print out each chunk

		$ipaddingL = $this->blk[$this->blklvl]['padding_left']; 
		$ipaddingR = $this->blk[$this->blklvl]['padding_right']; 
		$paddingL = ($ipaddingL * $this->k); 
		$paddingR = ($ipaddingR * $this->k);
		$this->cMarginL =  $this->blk[$this->blklvl]['border_left']['w'];
		$this->cMarginR =  $this->blk[$this->blklvl]['border_right']['w'];

		// Added mPDF 3.0 Float DIV
		$fpaddingR = 0;
		$fpaddingL = 0;

		$usey = $this->y + 0.002;
		if (($newblock) && ($blockstate==1 || $blockstate==3) && ($lineCount == 0) ) { 
			$usey += $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'];
		}

		// Set Current lineheight (correction factor)
		$lhfixed = false; 
		if (isset($this->blk[$this->blklvl]['line_height']) && $this->blk[$this->blklvl]['line_height']) {
			if (preg_match('/([0-9.,]+)mm/',$this->blk[$this->blklvl]['line_height'],$am)) { 
				$lhfixed = true; 
				$def_fontsize = $this->blk[$this->blklvl]['InlineProperties']['size']; 	// needs to be default font-size for block ****
				$this->lineheight_correction = $am[1] / $def_fontsize ;
			}
			else { 
				$this->lineheight_correction = $this->blk[$this->blklvl]['line_height']; 
			}
		} 
		else {
			$this->lineheight_correction = $this->normalLineheight; 
		}

		//  correct lineheight to maximum fontsize
		if ($lhfixed) { $maxlineHeight = $this->lineheight; }
		else { $maxlineHeight = 0; }
		$this->forceExactLineheight = true;
		$maxfontsize = 0;
		foreach ( $content as $k => $chunk )
		{
              $this->restoreFont( $font[ $k ],false );
		  if (!isset($this->objectbuffer[$k])) { 
			// Soft Hyphens chr(173)
			if (!$this->usingCoreFont) {
			      $content[$k] = $chunk = str_replace("\xc2\xad",'',$chunk ); 
			}
			else if ($this->FontFamily!='csymbol' && $this->FontFamily!='czapfdingbats') {
			      $content[$k] = $chunk = str_replace($this->chrs[173],'',$chunk );
			}
			// Special case of sub/sup carried over on its own to last line
			if (($this->SUB || $this->SUP) && count($content)==1) { $actfs = $this->FontSize*100/55; } // 55% is font change for sub/sup
			else { $actfs = $this->FontSize; }
			if (!$lhfixed) { $maxlineHeight = max($maxlineHeight,$actfs * $this->lineheight_correction ); }
			if ($lhfixed && ($actfs > $def_fontsize || ($actfs > ($lineHeight * $this->lineheight_correction) && $is_list))) { 
				$this->forceExactLineheight = false; 
			}
			$maxfontsize = max($maxfontsize,$actfs);
		  }
		}

		$lastfontreqstyle = $font[count($font)-1]['ReqFontStyle'];
		$lastfontstyle = $font[count($font)-1]['style'];
		if ($this->directionality == 'ltr' && strpos($lastfontreqstyle,"I") !== false && strpos($lastfontstyle,"I") === false) {	// Artificial italic
			$lastitalic = $this->FontSize*0.15*$this->k;
		}
		else { $lastitalic = 0; }



		// when every text item checked i.e. $maxfontsize is set properly

		$af = 0; 	// Above font
		$bf = 0; 	// Below font
		$mta = 0;	// Maximum top-aligned 
		$mba = 0;	// Maximum bottom-aligned 

		foreach ( $content as $k => $chunk )
		{
		  if (isset($this->objectbuffer[$k])) { 
			$oh = $this->objectbuffer[$k]['OUTER-HEIGHT'];
			$va = $this->objectbuffer[$k]['vertical-align']; // = $objattr['vertical-align'] = set as M,T,B,S
			if ($lhfixed && $oh > $def_fontsize) { $this->forceExactLineheight = false; }

			if ($va == 'BS') {	//  (BASELINE default)
				$af = max($af, ($oh - ($maxfontsize * (0.5 + $this->baselineC))));
			}
			else if ($va == 'M') { 
				$af = max($af, ($oh - $maxfontsize)/2);
				$bf = max($bf, ($oh - $maxfontsize)/2);
			}
			else if ($va == 'TT') { 
				$bf = max($bf, ($oh - $maxfontsize));
			}
			else if ($va == 'TB') { 
				$af = max($af, ($oh - $maxfontsize));
			}
			else if ($va == 'T') { 
				$mta = max($mta, $oh);
			}
			else if ($va == 'B') { 
				$mba = max($mba, $oh);
			}
		  }
		}
		if ((!$lhfixed || !$this->forceExactLineheight) && ($af > (($maxlineHeight - $maxfontsize)/2) || $bf > (($maxlineHeight - $maxfontsize)/2))) {
			$maxlineHeight = $maxfontsize + $af + $bf;
		}
		else if (!$lhfixed) { $af = $bf = ($maxlineHeight - $maxfontsize)/2; }
		if ($mta > $maxlineHeight) { 
			$bf += ($mta - $maxlineHeight);
			$maxlineHeight = $mta;
		}
		if ($mba > $maxlineHeight) { 
			$af += ($mba - $maxlineHeight);
			$maxlineHeight = $mba;
		}

		$lineHeight = $maxlineHeight;
		// If NOT images, and maxfontsize NOT > lineHeight - this value determines text baseline positioning
		if ($lhfixed && $af==0 && $bf==0 && $maxfontsize<=($def_fontsize * $this->lineheight_correction * 0.8 )) { 
			$this->linemaxfontsize = $def_fontsize; 
		}
		else { $this->linemaxfontsize = $maxfontsize; }

		// Get PAGEBREAK TO TEST for height including the bottom border/padding
		$check_h = max($this->divheight,$lineHeight);

		if ($this->blklvl > 0 && !$is_table) { 
		   if ($endofblock && $blockstate > 1) { 
			if ($this->blk[$this->blklvl]['page_break_after_avoid']) {  $check_h += $lineHeight; }
			$check_h += ($this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w']);
		   }
		   if (($newblock && ($blockstate==1 || $blockstate==3) && $lineCount == 0) || ($endofblock && $blockstate > 1 && $lineCount == 0)) { 
			$check_h += ($this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['border_top']['w']);
		   }
		}

		// Force PAGE break if column height cannot take check-height
		if ($this->ColActive && $check_h > ($this->PageBreakTrigger - $this->y0)) { $this->CurrCol = $this->NbCol; } 

		// PAGEBREAK
		//'If' below used in order to fix "first-line of other page with justify on" bug
		if(!$is_table && ($this->y+$check_h) > $this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak()) {
    	     		$bak_x=$this->x;//Current X position
			// WORD SPACING
			$ws=$this->ws;//Word Spacing
			$charspacing=$this->charspacing;//Character Spacing
			$this->ResetSpacing();

		      $this->AddPage($this->CurOrientation);

		      $this->x=$bak_x;
			// Added to correct for OddEven Margins
			$currentx += $this->MarginCorrection;
			$this->x += $this->MarginCorrection;

			// WORD SPACING
			$this->SetSpacing($charspacing,$ws);
		}

		// mPDF 5.0
		if ($this->keep_block_together && !$is_table && $this->kt_p00 < $this->page && ($this->y+$check_h) > $this->kt_y00) {
			$this->printdivbuffer();
			$this->keep_block_together = 0;
		}


		// TOP MARGIN
		if ($newblock && ($blockstate==1 || $blockstate==3) && ($this->blk[$this->blklvl]['margin_top']) && $lineCount == 0 && !$is_table && !$is_list) { 
			$this->DivLn($this->blk[$this->blklvl]['margin_top'],$this->blklvl-1,true,$this->blk[$this->blklvl]['margin_collapse']); 
		}

		if ($newblock && ($blockstate==1 || $blockstate==3) && $lineCount == 0 && !$is_table && !$is_list) { 
			$this->blk[$this->blklvl]['y0'] = $this->y;
			$this->blk[$this->blklvl]['startpage'] = $this->page;
		}

	// ADDED for Paragraph_indent
	$WidthCorrection = 0;
	if (($newblock) && ($blockstate==1 || $blockstate==3) && isset($this->blk[$this->blklvl]['text_indent']) && ($lineCount == 0) && (!$is_table) && (!$is_list) && ($align != 'C')) { 
		$ti = $this->ConvertSize($this->blk[$this->blklvl]['text_indent'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); 
		$WidthCorrection = ($ti*$this->k); 
	} 


	// PADDING and BORDER spacing/fill
	if (($newblock) && ($blockstate==1 || $blockstate==3) && (($this->blk[$this->blklvl]['padding_top']) || ($this->blk[$this->blklvl]['border_top'])) && ($lineCount == 0) && (!$is_table) && (!$is_list)) { 
			// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
			$this->DivLn($this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'],-3,true,false,1); 
			$this->x = $currentx;
	}


	// Added mPDF 3.0 Float DIV
	$fpaddingR = 0;
	$fpaddingL = 0;

	$usey = $this->y + 0.002;
	if (($newblock) && ($blockstate==1 || $blockstate==3) && ($lineCount == 0) ) { 
		$usey += $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'];
	}

	if ($content) {
		$empty = $maxWidth - $lastitalic-$WidthCorrection - $contentWidth - (($this->cMarginL+$this->cMarginR)* $this->k) - ($paddingL+$paddingR +(($fpaddingL + $fpaddingR) * $this->k) );
		$empty /= $this->k;

		// In FinishFlowing Block no lines are justified as it is always last line
		// but if orphansAllowed have allowed content width to go over max width, use J charspacing to compress line
		// JUSTIFICATION J - NOT!
		$nb_carac = 0;
		$nb_spaces = 0;
		foreach ( $content as $k => $chunk ) {
			if (!isset($this->objectbuffer[$k]) || (isset($this->objectbuffer[$k]) && !$this->objectbuffer[$k])) {
				if ($this->usingCoreFont) {
				      $chunk = str_replace($this->chrs[160],$this->chrs[32],$chunk );
				}
				else {
				      $chunk = str_replace($this->chrs[194].$this->chrs[160],$this->chrs[32],$chunk ); 
				}
				$nb_carac += mb_strlen( $chunk, $this->mb_enc );  
				$nb_spaces += mb_substr_count( $chunk,' ', $this->mb_enc );  
			}
		}
		// if it's justified, we need to find the char/word spacing (or if orphans have allowed length of line to go over the maxwidth)
		// If "orphans" in fact is just a final space - ignore this
		if (((($contentWidth + $lastitalic) > $maxWidth) && ($content[count($content)-1] != ' ') )  ||
			(!$endofblock && $align=='J' && ($next=='image' || $next=='select' || $next=='input' || $next=='textarea' || ($next=='br' && $this->justifyB4br)))
			) {
 		  // WORD SPACING
			list($charspacing,$ws) = $this->GetJspacing($nb_carac,$nb_spaces,($maxWidth-$lastitalic-$contentWidth-$WidthCorrection-(($this->cMarginL+$this->cMarginR)*$this->k)-($paddingL+$paddingR +(($fpaddingL + $fpaddingR) * $this->k) )));
			$this->SetSpacing($charspacing,$ws);
		}
		// Check if will fit at word/char spacing of previous line - if so continue it
		// but only allow a maximum of $this->jSmaxWordLast and $this->jSmaxCharLast
		else if ($contentWidth < ($maxWidth - $lastitalic-$WidthCorrection - (($this->cMarginL+$this->cMarginR)* $this->k) - ($paddingL+$paddingR +(($fpaddingL + $fpaddingR) * $this->k)))) {
			if ($this->ws > $this->jSmaxWordLast) {
				$ws=$this->jSmaxWord;
				$this->_out(sprintf('BT %.3f Tw ET',$ws)); 
				$this->ws=$ws;
			}
			if ($this->charspacing > $this->jSmaxCharLast) {
				$charspacing=$this->jSmaxCharLast;
				$this->_out(sprintf('BT %.3f Tc ET',$charspacing)); 
				$this->charspacing=$charspacing;
			}
			$check = $maxWidth - $lastitalic-$WidthCorrection - $contentWidth - (($this->cMarginL+$this->cMarginR)* $this->k) - ($paddingL+$paddingR +(($fpaddingL + $fpaddingR) * $this->k) ) - ( $this->charspacing * $nb_carac) - ( $this->ws * $nb_spaces);
			if ($check <= 0) {
				$this->ResetSpacing();
			}
		}
		else {
			$this->ResetSpacing();
		}

		$empty = $maxWidth - $lastitalic-$WidthCorrection - $contentWidth - (($this->cMarginL+$this->cMarginR)* $this->k) - ($paddingL+$paddingR +(($fpaddingL + $fpaddingR) * $this->k) ) - ( $this->charspacing * $nb_carac) - ( $this->ws * $nb_spaces);
		$empty /= $this->k;

		if (!$is_table) { 
			$this->maxPosR = max($this->maxPosR , ($this->w - $this->rMargin - $this->blk[$this->blklvl]['outer_right_margin'] - $empty)); 
			$this->maxPosL = min($this->maxPosL , ($this->lMargin + $this->blk[$this->blklvl]['outer_left_margin'] + $empty)); 
		}

		$arraysize = count($content);

		$margins = ($this->cMarginL+$this->cMarginR) + ($ipaddingL+$ipaddingR + $fpaddingR + $fpaddingR );

		if (!$is_table) { $this->DivLn($lineHeight,$this->blklvl,false); }	// false -> don't advance y

		// DIRECTIONALITY RTL
		$all_rtl = false;
		$contains_rtl = false;


		$this->x = $currentx + $this->cMarginL + $ipaddingL + $fpaddingL;
		if ($align == 'R') { $this->x += $empty; }
		else if ($align == 'J')	{
			if ($this->directionality == 'rtl' && $contains_rtl) { $this->x += $empty; }
			else if ($this->directionality == 'ltr' && $all_rtl) { $this->x += $empty; }
		}
		else if ($align == 'C') { $this->x += ($empty / 2); }

		// Paragraph INDENT
		$WidthCorrection = 0; 
		if (($newblock) && ($blockstate==1 || $blockstate==3) && isset($this->blk[$this->blklvl]['text_indent']) && ($lineCount == 0) && (!$is_table) && (!$is_list) && ($align !='C')) { 
			$ti = $this->ConvertSize($this->blk[$this->blklvl]['text_indent'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); 
			$this->x += $ti; 
		}


          foreach ( $content as $k => $chunk )
          {

			// FOR IMAGES
		if (($this->directionality=='rtl' && $contains_rtl) || $all_rtl) { $dirk = $arraysize-1 - $k; } else { $dirk = $k; }

		$va = 'M';	// default for text
		if (isset($this->objectbuffer[$dirk]) && $this->objectbuffer[$dirk]) {
			$xadj = $this->x - $this->objectbuffer[$dirk]['OUTER-X']; 
			$this->objectbuffer[$dirk]['OUTER-X'] += $xadj;
			$this->objectbuffer[$dirk]['BORDER-X'] += $xadj;
			$this->objectbuffer[$dirk]['INNER-X'] += $xadj;
			$va = $this->objectbuffer[$dirk]['vertical-align'];
			$yadj = $this->y - $this->objectbuffer[$dirk]['OUTER-Y'];
			if ($va == 'BS') { 
				$yadj += $af + ($this->linemaxfontsize * (0.5 + $this->baselineC)) - $this->objectbuffer[$dirk]['OUTER-HEIGHT'];
			}
			else if ($va == 'M' || $va == '') { 
				$yadj += $af + ($this->linemaxfontsize /2) - ($this->objectbuffer[$dirk]['OUTER-HEIGHT']/2);
			}
			else if ($va == 'TB') { 
				$yadj += $af + $this->linemaxfontsize - $this->objectbuffer[$dirk]['OUTER-HEIGHT'];
			}
			else if ($va == 'TT') { 
				$yadj += $af;
			}
			else if ($va == 'B') { 
				$yadj += $af + $this->linemaxfontsize + $bf - $this->objectbuffer[$dirk]['OUTER-HEIGHT'];
			}
			else if ($va == 'T') { 
				$yadj += 0;
			}
			$this->objectbuffer[$dirk]['OUTER-Y'] += $yadj;
			$this->objectbuffer[$dirk]['BORDER-Y'] += $yadj;
			$this->objectbuffer[$dirk]['INNER-Y'] += $yadj;
		}



			// DIRECTIONALITY RTL
			if ((($this->directionality == 'rtl') && ($contains_rtl )) || ($all_rtl )) { $this->restoreFont( $font[ $arraysize-1 - $k ] ); }
			else { $this->restoreFont( $font[ $k ] ); }
	 		// *********** SPAN BACKGROUND COLOR ***************** //
			if (isset($this->spanbgcolor) && $this->spanbgcolor) { 
				$cor = $this->spanbgcolorarray;
				$this->SetFillColor($cor['R'],$cor['G'],$cor['B']);
				$save_fill = $fill; $spanfill = 1; $fill = 1;
			}
			// WORD SPACING
		      $stringWidth = $this->GetStringWidth($chunk ) + ( $this->charspacing * mb_strlen($chunk,$this->mb_enc ) / $this->k )  
				+ ( $this->ws * mb_substr_count($chunk,' ',$this->mb_enc ) / $this->k );
			if (isset($this->objectbuffer[$dirk])) { 
				if ($this->objectbuffer[$dirk]['type']=='dottab') { 
					$this->objectbuffer[$dirk]['OUTER-WIDTH'] +=$empty; 
				}
				$stringWidth = $this->objectbuffer[$dirk]['OUTER-WIDTH'];
			}

			if ($stringWidth==0) { $stringWidth = 0.000001; }	// mPDF 5.0
			if ($k == $arraysize-1) $this->Cell( $stringWidth, $lineHeight, $chunk, '', 1, '', $fill, $this->HREF , $currentx,0,0,'M', $fill, $af, $bf ); //mono-style line or last part (skips line)
			else $this->Cell( $stringWidth, $lineHeight, $chunk, '', 0, '', $fill, $this->HREF, 0, 0,0,'M', $fill, $af, $bf );//first or middle part


	 		// *********** SPAN BACKGROUND COLOR OFF - RESET BLOCK BGCOLOR ***************** //
			if (isset($spanfill) && $spanfill) { 
				$fill = $save_fill; $spanfill = 0; 
				if ($fill) { $this->SetFillColor($bcor['R'],$bcor['G'],$bcor['B']); }
			}
          }

	$this->printobjectbuffer($is_table);


	$this->objectbuffer = array();


	$this->ResetSpacing();



	}	// END IF CONTENT



	// PADDING and BORDER spacing/fill
	if ($endofblock && ($blockstate > 1) && ($this->blk[$this->blklvl]['padding_bottom'] || $this->blk[$this->blklvl]['border_bottom'] || $this->blk[$this->blklvl]['css_set_height']) && (!$is_table) && (!$is_list)) { 
			// If CSS height set, extend bottom - if on same page as block started, and CSS HEIGHT > actual height, 
			//	and does not force pagebreak
			$extra = 0;
			if ($this->blk[$this->blklvl]['css_set_height'] && $this->blk[$this->blklvl]['startpage']==$this->page) {
				// predicted height
				$h1 = ($this->y-$this->blk[$this->blklvl]['y0']) + $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w'];
				if ($h1 < $this->blk[$this->blklvl]['css_set_height']) { $extra = $this->blk[$this->blklvl]['css_set_height'] - $h1; }
				if($this->y + $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w'] + $extra > $this->PageBreakTrigger) {
					$extra = $this->PageBreakTrigger - ($this->y + $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w']); 
				}
			}

			// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
			$this->DivLn($this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w'] + $extra,-3,true,false,2); 
			$this->x = $currentx;


	}

	// SET Bottom y1 of block (used for painting borders)
	if (($endofblock) && ($blockstate > 1) && (!$is_table) && (!$is_list)) { 
		$this->blk[$this->blklvl]['y1'] = $this->y;
	}

	// BOTTOM MARGIN
	if (($endofblock) && ($blockstate > 1) && ($this->blk[$this->blklvl]['margin_bottom']) && (!$is_table) && (!$is_list)) { 
		if($this->y+$this->blk[$this->blklvl]['margin_bottom'] < $this->PageBreakTrigger and !$this->InFooter) {
		  $this->DivLn($this->blk[$this->blklvl]['margin_bottom'],$this->blklvl-1,true,$this->blk[$this->blklvl]['margin_collapse']); 
		}
	}

	// Reset lineheight
	$lineHeight = $this->divheight;
}





function printobjectbuffer($is_table=false) {
		if ($is_table && $this->shrin_k > 1) { $k = $this->shrin_k; } 
		else { $k = 1; }
		$save_y = $this->y;
		$save_x = $this->x;
		$save_currentfontfamily = $this->FontFamily;
		$save_currentfontsize = $this->FontSizePt;
		$save_currentfontstyle = $this->FontStyle.($this->U ? 'U' : '').($this->S ? 'S' : '');
		if ($this->directionality == 'rtl') { $rtlalign = 'R'; } else { $rtlalign = 'L'; }
		foreach ($this->objectbuffer AS $ib => $objattr) { 
		   if ($objattr['type'] == 'bookmark' || $objattr['type'] == 'indexentry' || $objattr['type'] == 'toc') {
			$x = $objattr['OUTER-X']; 
			$y = $objattr['OUTER-Y'];
			$this->y = $y - $this->FontSize/2;
			$this->x = $x;
			if ($objattr['type'] == 'bookmark' ) { $this->Bookmark($objattr['CONTENT'],$objattr['bklevel'] ,$y - $this->FontSize); }	// *BOOKMARKS*
		   }
		   else { 
			$y = $objattr['OUTER-Y'];
			$x = $objattr['OUTER-X'];
			$w = $objattr['OUTER-WIDTH'];
			$h = $objattr['OUTER-HEIGHT'];
			if (isset($objattr['text'])) { $texto = $objattr['text']; }
			$this->y = $y;
			$this->x = $x;
			if (isset($objattr['fontfamily'])) { $this->SetFont($objattr['fontfamily'],'',$objattr['fontsize'] ); }
		   }

		// HR
		   if ($objattr['type'] == 'hr') {
			$this->SetDrawColor($objattr['color']['R'],$objattr['color']['G'],$objattr['color']['B']);
			switch($objattr['align']) {
      		    case 'C':
      		        $empty = $objattr['OUTER-WIDTH'] - $objattr['INNER-WIDTH'];
      		        $empty /= 2;
      		        $x += $empty;
     		        	  break;
      		    case 'R':
      		        $empty = $objattr['OUTER-WIDTH'] - $objattr['INNER-WIDTH'];
      		        $x += $empty;
      		        break;
			}
      		$oldlinewidth = $this->LineWidth;
			$this->SetLineWidth($objattr['linewidth']/$k );
			$this->y += ($objattr['linewidth']/2) + $objattr['margin_top']/$k;
			$this->Line($x,$this->y,$x+$objattr['INNER-WIDTH'],$this->y);
			$this->SetLineWidth($oldlinewidth);
			$this->SetDrawColor(0);
		   }
		// IMAGE
		   if ($objattr['type'] == 'image') {
			if (isset($objattr['opacity'])) { $this->SetAlpha($objattr['opacity']); }
			$rotate = 0;
			$obiw = $objattr['INNER-WIDTH'];
			$obih = $objattr['INNER-HEIGHT'];
			$sx = $objattr['INNER-WIDTH']*$this->k / $objattr['orig_w'];
			$sy = abs($objattr['INNER-HEIGHT'])*$this->k / abs($objattr['orig_h']);
			$sx = ($objattr['INNER-WIDTH']*$this->k / $objattr['orig_w']);
			$sy = ($objattr['INNER-HEIGHT']*$this->k / $objattr['orig_h']);

			if (isset($objattr['ROTATE'])) { $rotate = $objattr['ROTATE']; }
			if ($rotate==90) { 
				// Clockwise
				$obiw = $objattr['INNER-HEIGHT'];
				$obih = $objattr['INNER-WIDTH'];
				$tr = $this->transformTranslate(0, -$objattr['INNER-WIDTH'], true) ;
				$tr .= ' '. $this->transformRotate(90, $objattr['INNER-X'],($objattr['INNER-Y'] +$objattr['INNER-WIDTH'] ),true) ;
				$sx = $obiw*$this->k / $objattr['orig_h'];
				$sy = $obih*$this->k / $objattr['orig_w'];
			}
			else if ($rotate==-90) { 
				// AntiClockwise
				$obiw = $objattr['INNER-HEIGHT'];
				$obih = $objattr['INNER-WIDTH'];
				$tr = $this->transformTranslate($objattr['INNER-WIDTH'], ($objattr['INNER-HEIGHT']-$objattr['INNER-WIDTH']), true) ;
				$tr .= ' '. $this->transformRotate(-90, $objattr['INNER-X'],($objattr['INNER-Y'] +$objattr['INNER-WIDTH'] ),true) ;
				$sx = $obiw*$this->k / $objattr['orig_h'];
				$sy = $obih*$this->k / $objattr['orig_w'];
			}
			else if ($rotate==180) { 
				// Mirror
				$tr = $this->transformTranslate($objattr['INNER-WIDTH'], -$objattr['INNER-HEIGHT'], true) ;
				$tr .= ' '. $this->transformRotate(180, $objattr['INNER-X'],($objattr['INNER-Y'] +$objattr['INNER-HEIGHT'] ),true) ;
			}
			else { $tr = ''; }
			$tr = trim($tr);
			if ($tr) { $tr .= ' '; }
			if (isset($objattr['itype']) && $objattr['itype']=='svg') { 
				$outstring = sprintf('q '.$tr.'%.3f 0 0 %.3f %.3f %.3f cm /FO%d Do Q', $sx, -$sy, $objattr['INNER-X']*$this->k-$sx*$objattr['wmf_x'], (($this->h-$objattr['INNER-Y'])*$this->k)+$sy*$objattr['wmf_y'], $objattr['ID']);
			}
			else { 
				$outstring = sprintf("q ".$tr."%.3f 0 0 %.3f %.3f %.3f cm /I%d Do Q",$obiw*$this->k, $obih*$this->k, $objattr['INNER-X'] *$this->k, ($this->h-($objattr['INNER-Y'] +$obih ))*$this->k,$objattr['ID'] );
			}
			$this->_out($outstring);
			// LINK
			if (isset($objattr['link'])) $this->Link($objattr['INNER-X'],$objattr['INNER-Y'],$objattr['INNER-WIDTH'],$objattr['INNER-HEIGHT'],$objattr['link']);
			if (isset($objattr['BORDER-WIDTH'])) { $this->PaintImgBorder($objattr,$is_table); }
			if (isset($objattr['opacity'])) { $this->SetAlpha(1); }
		   }



		   $this->ResetSpacing();

		   if ($objattr['type'] == 'dottab') {
				$sp = $this->GetStringWidth(' ');
				$nb=floor(($w-2*$sp)/$this->GetStringWidth('.'));
				if ($nb>0) { $dots=' '.str_repeat('.',$nb).' '; }
				else { $dots=' '; }
				// mPDF 5.0
				$this->SetTextColor($objattr['colorarray']['R'],$objattr['colorarray']['G'],$objattr['colorarray']['B']);
				$this->Cell($w,$h,$dots,0,0,'C');
				// mPDF 5.0
				$this->SetTextColor(0);
		   }

		}
		$this->SetFont($save_currentfontfamily,$save_currentfontstyle,$save_currentfontsize);
		$this->y = $save_y;
		$this->x = $save_x;
		unset($content);
}


function WriteFlowingBlock( $s)
{
    $currentx = $this->x; 
    $is_table = $this->flowingBlockAttr[ 'is_table' ];
    $is_list = $this->flowingBlockAttr[ 'is_list' ];
    // width of all the content so far in points
    $contentWidth =& $this->flowingBlockAttr[ 'contentWidth' ];
    // cell width in points
    $maxWidth =& $this->flowingBlockAttr[ 'width' ];
    $lineCount =& $this->flowingBlockAttr[ 'lineCount' ];
    // line height in user units
    $lineHeight =& $this->flowingBlockAttr[ 'height' ];
    $align =& $this->flowingBlockAttr[ 'align' ];
    $content =& $this->flowingBlockAttr[ 'content' ];
    $font =& $this->flowingBlockAttr[ 'font' ];
    $valign =& $this->flowingBlockAttr[ 'valign' ];
    $blockstate = $this->flowingBlockAttr[ 'blockstate' ];

    $newblock = $this->flowingBlockAttr[ 'newblock' ];
	// *********** BLOCK BACKGROUND COLOR ***************** //
	if ($this->blk[$this->blklvl]['bgcolor'] && !$is_table) {
		$fill = 0;
//		$fill = 1;
//		$bcor = $this->blk[$this->blklvl]['bgcolorarray'];
//		$this->SetFillColor($bcor['R'],$bcor['G'],$bcor['B']);
	}
	else {
		$this->SetFillColor(255);
		$fill = 0;
	}
    $font[] = $this->saveFont();
    $content[] = '';
    $currContent =& $content[ count( $content ) - 1 ];
    // where the line should be cutoff if it is to be justified
    $cutoffWidth = $contentWidth;

	$curlyquote = mb_convert_encoding("\xe2\x80\x9e",$this->mb_enc,'UTF-8');
	$curlylowquote = mb_convert_encoding("\xe2\x80\x9d",$this->mb_enc,'UTF-8');

	// COLS
	$oldcolumn = $this->CurrCol;


		$ipaddingL = $this->blk[$this->blklvl]['padding_left']; 
		$ipaddingR = $this->blk[$this->blklvl]['padding_right']; 
		$paddingL = ($ipaddingL * $this->k); 
		$paddingR = ($ipaddingR * $this->k); 
		$this->cMarginL =  $this->blk[$this->blklvl]['border_left']['w'];
		$cpaddingadjustL = -$this->cMarginL;
		$this->cMarginR =  $this->blk[$this->blklvl]['border_right']['w'];
		$cpaddingadjustR = -$this->cMarginR;
		// Added mPDF 3.0 Float DIV
		$fpaddingR = 0;
		$fpaddingL = 0;

		$usey = $this->y + 0.002;
		if (($newblock) && ($blockstate==1 || $blockstate==3) && ($lineCount == 0) ) { 
			$usey += $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'];
		}

     //OBJECTS - IMAGES & FORM Elements (NB has already skipped line/page if required - in printbuffer)
      if (substr($s,0,3) == "\xbb\xa4\xac") { //identifier has been identified!
		$objattr = $this->_getObjAttr($s);
		$h_corr = 0; 
			if (($newblock) && ($blockstate==1 || $blockstate==3) && ($lineCount == 0) && (!$is_table)) { $h_corr = $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w']; }
			$maximumW = ($maxWidth/$this->k) - ($this->blk[$this->blklvl]['padding_left'] + $this->blk[$this->blklvl]['border_left']['w'] + $this->blk[$this->blklvl]['padding_right'] + $this->blk[$this->blklvl]['border_right']['w'] + $fpaddingL + $fpaddingR ); 
		$objattr = $this->inlineObject($objattr['type'],$this->lMargin + $fpaddingL + ($contentWidth/$this->k),($this->y + $h_corr), $objattr, $this->lMargin,($contentWidth/$this->k),$maximumW,$lineHeight,true,$is_table);

		// SET LINEHEIGHT for this line ================ RESET AT END
		$lineHeight = MAX($lineHeight,$objattr['OUTER-HEIGHT']);
		$this->objectbuffer[count($content)-1] = $objattr;
		// if (isset($objattr['vertical-align'])) { $valign = $objattr['vertical-align']; }
		// else { $valign = ''; }
		$contentWidth += ($objattr['OUTER-WIDTH'] * $this->k);
		return;
	}


   if ($this->usingCoreFont) {
	$tmp = strlen( $s );
   }
   else {
	$tmp = mb_strlen( $s, $this->mb_enc );
   }

   $orphs = 0; 
   $check = 0;

   // for every character in the string
   for ( $i = 0; $i < $tmp; $i++ )  {

	// extract the current character
	// get the width of the character in points
	if ($this->usingCoreFont) {
       	$c = $s[$i];
		// Soft Hyphens chr(173)
		if ($c == chr(173) && ($this->FontFamily!='csymbol' && $this->FontFamily!='czapfdingbats')) { $cw = 0;  }
		else if ($this->S) { $cw = ($this->GetStringWidth($c) * $this->k); }	// mPDF 5.0
		else { $cw = $this->CurrentFont[ 'cw' ][ $c ] * ( $this->FontSizePt / 1000 ); }
	}
	else {
	      $c = mb_substr($s,$i,1,$this->mb_enc );
		$cw = ($this->GetStringWidth($c) * $this->k);
	}

	if ($c==' ') { $check = 1; }

	// CHECK for ORPHANS
	// mPDF 5.0 Added "]"
	else if ($c=='.' || $c==',' || $c==')' || $c==']' || $c==';' || $c==':' || $c=='!' || $c=='?'|| $c=='"' || $c==$curlyquote || $c==$curlylowquote || $c=="\xef\xbc\x8c" || $c=="\xef\xbc\x8e" || $c=="\xe3\x80\x81" || $c=="\xe3\x80\x82")  {$check++; }
	else { $check = 0; }

	// There's an orphan '. ' or ', ' or <sup>32</sup> about to be cut off at the end of line
	if($check==1) {
		$currContent .= $c;
		$cutoffWidth = $contentWidth;
		$contentWidth += $cw;
		continue;
	}
	if(($this->SUP || $this->SUB) && ($orphs < $this->orphansAllowed)) {	// ? disable orphans in table if  borders used
		$currContent .= $c;
		$cutoffWidth = $contentWidth;
		$contentWidth += $cw;
		$orphs++;
		continue;
	}
	else { $orphs = 0; }

	// ADDED for Paragraph_indent
	$WidthCorrection = 0; 
	if (($newblock) && ($blockstate==1 || $blockstate==3) && isset($this->blk[$this->blklvl]['text_indent']) && ($lineCount == 0) && (!$is_table) && (!$is_list) && ($align != 'C')) { 
		$ti = $this->ConvertSize($this->blk[$this->blklvl]['text_indent'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); 
		$WidthCorrection = ($ti*$this->k); 
	} 

	// Added mPDF 3.0 Float DIV
	$fpaddingR = 0;
	$fpaddingL = 0;

	$usey = $this->y + 0.002;
	if (($newblock) && ($blockstate==1 || $blockstate==3) && ($lineCount == 0) ) { 
		$usey += $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'];
	}




       // try adding another char
	if (( $contentWidth + $cw > $maxWidth - $WidthCorrection - (($this->cMarginL+$this->cMarginR)*$this->k) - ($paddingL+$paddingR +(($fpaddingL + $fpaddingR) * $this->k) ) +  0.001))  {// 0.001 is to correct for deviations converting mm=>pts
		// it won't fit, output what we already have
		$lineCount++;
 
		// contains any content that didn't make it into this print
		$savedContent = '';
		$savedFont = array();
		$savedObj = array();



		// mPDF 5.0
		// CJK - allow to split anywhere, but strip CJK space at end of line
		// &#x3000; = \xe3\x80\x80 = CJK space
		if ($this->checkCJK && preg_match("/([".$this->pregCJKchars."])/u", $c)) { 
			$words = array(); $words[] = preg_replace("/\xe3\x80\x80$/",'',$currContent) ; 
		}
		// cut off and save any partial words at the end of the string
		else { 

			$words = explode( ' ', $currContent ); 
			///////////////////
			// HYPHENATION
			$currWord = $words[count($words)-1] ;
			$success = false;
		}	// *CJK*


		// if it looks like we didn't finish any words for this chunk
		if ( count( $words ) == 1 ) {
		  // TO correct for error when word too wide for page - but only when one long word from left to right margin
		  if (count($content) == 1 && $currContent != ' ') {
			$lastContent = $words[0]; 
			$savedFont = $this->saveFont();
			// replace the current content with the cropped version
			$currContent = rtrim( $lastContent );
		  }
		  else {
			// save and crop off the content currently on the stack
			$savedContent = array_pop( $content );
			$savedFont = array_pop( $font );
			// trim any trailing spaces off the last bit of content
			$currContent =& $content[ count( $content ) - 1 ];
			$currContent = rtrim( $currContent );
		  }
		}
		else {	// otherwise, we need to find which bit to cut off
             $lastContent = '';
              for ( $w = 0; $w < count( $words ) - 1; $w++) { $lastContent .= $words[ $w ]." "; }
              $savedContent = $words[ count( $words ) - 1 ];
              $savedFont = $this->saveFont();
              // replace the current content with the cropped version
              $currContent = rtrim( $lastContent );
		}

		if (isset($this->objectbuffer[(count($content)-1)]) && $this->objectbuffer[(count($content)-1)]['type']=='dottab') {
			$savedObj = array_pop( $this->objectbuffer );
			$contentWidth -= ($this->objectbuffer[(count($content)-1)]['OUTER-WIDTH'] * $this->k);
		}

		// Set Current lineheight (correction factor)
		$lhfixed = false; 
		if (isset($this->blk[$this->blklvl]['line_height']) && $this->blk[$this->blklvl]['line_height']) {
			if (preg_match('/([0-9.,]+)mm/',$this->blk[$this->blklvl]['line_height'],$am)) { 
				$lhfixed = true; 
				$def_fontsize = $this->blk[$this->blklvl]['InlineProperties']['size']; 	// needs to be default font-size for block ****
				$this->lineheight_correction = $am[1] / $def_fontsize ;
			}
			else { 
				$this->lineheight_correction = $this->blk[$this->blklvl]['line_height']; 
			}
		} 
		else {
			$this->lineheight_correction = $this->normalLineheight; 
		}
		// update $contentWidth and $cutoffWidth since they changed with cropping
		// Also correct lineheight to maximum fontsize (not for tables)
		$contentWidth = 0;
		//  correct lineheight to maximum fontsize
		if ($lhfixed) { $maxlineHeight = $this->lineheight; }
		else { $maxlineHeight = 0; }
		$this->forceExactLineheight = true;
		$maxfontsize = 0;
		foreach ( $content as $k => $chunk )
		{
              $this->restoreFont( $font[ $k ]);
		  if (!isset($this->objectbuffer[$k])) { 
			if (!$this->usingCoreFont) {
			      $content[$k] = $chunk = str_replace("\xc2\xad",'',$chunk ); 
			}
			// Soft Hyphens chr(173)
			else if ($this->FontFamily!='csymbol' && $this->FontFamily!='czapfdingbats') {
			      $content[$k] = $chunk = str_replace($this->chrs[173],'',$chunk );
			}
			$contentWidth += $this->GetStringWidth( $chunk ) * $this->k; 
			if (!$lhfixed) { $maxlineHeight = max($maxlineHeight,$this->FontSize * $this->lineheight_correction ); }
			if ($lhfixed && ($this->FontSize > $def_fontsize || ($this->FontSize > ($lineHeight * $this->lineheight_correction) && $is_list))) { 
				$this->forceExactLineheight = false; 
			}
			$maxfontsize = max($maxfontsize,$this->FontSize); 
		  }
		}

		$lastfontreqstyle = $font[count($font)-1]['ReqFontStyle'];
		$lastfontstyle = $font[count($font)-1]['style'];
		if ($this->directionality == 'ltr' && strpos($lastfontreqstyle,"I") !== false && strpos($lastfontstyle,"I") === false) {	// Artificial italic
			$lastitalic = $this->FontSize*0.15*$this->k;
		}
		else { $lastitalic = 0; }



		// when every text item checked i.e. $maxfontsize is set properly

		$af = 0; 	// Above font
		$bf = 0; 	// Below font
		$mta = 0;	// Maximum top-aligned 
		$mba = 0;	// Maximum bottom-aligned 

		foreach ( $content as $k => $chunk ) {
		  if (isset($this->objectbuffer[$k]) && $this->objectbuffer[$k]) { 
			$contentWidth += $this->objectbuffer[$k]['OUTER-WIDTH'] * $this->k; 
			$oh = $this->objectbuffer[$k]['OUTER-HEIGHT'];
			$va = $this->objectbuffer[$k]['vertical-align']; // = $objattr['vertical-align'] = set as M,T,B,S
			if ($lhfixed && $oh > $def_fontsize) { $this->forceExactLineheight = false; }

			if ($va == 'BS') {	//  (BASELINE default)
				$af = max($af, ($oh - ($maxfontsize * (0.5 + $this->baselineC))));
			}
			else if ($va == 'M') { 
				$af = max($af, ($oh - $maxfontsize)/2);
				$bf = max($bf, ($oh - $maxfontsize)/2);
			}
			else if ($va == 'TT') { 
				$bf = max($bf, ($oh - $maxfontsize));
			}
			else if ($va == 'TB') { 
				$af = max($af, ($oh - $maxfontsize));
			}
			else if ($va == 'T') { 
				$mta = max($mta, $oh);
			}
			else if ($va == 'B') { 
				$mba = max($mba, $oh);
			}
		  }
		}
		if ((!$lhfixed || !$this->forceExactLineheight) && ($af > (($maxlineHeight - $maxfontsize)/2) || $bf > (($maxlineHeight - $maxfontsize)/2))) {
			$maxlineHeight = $maxfontsize + $af + $bf;
		}
		else if (!$lhfixed) { $af = $bf = ($maxlineHeight - $maxfontsize)/2; }

		if ($mta > $maxlineHeight) { 
			$bf += ($mta - $maxlineHeight);
			$maxlineHeight = $mta;
		}
		if ($mba > $maxlineHeight) { 
			$af += ($mba - $maxlineHeight);
			$maxlineHeight = $mba;
		}


		$lineHeight = $maxlineHeight; 
		$cutoffWidth = $contentWidth;
		// If NOT images, and maxfontsize NOT > lineHeight - this value determines text baseline positioning
		if ($lhfixed && $af==0 && $bf==0 && $maxfontsize<=($def_fontsize * $this->lineheight_correction * 0.8 )) { 
			$this->linemaxfontsize = $def_fontsize; 
		}
		else { $this->linemaxfontsize = $maxfontsize; }


		// JUSTIFICATION J
		$nb_carac = 0;
		$nb_spaces = 0;
		// if it's justified, we need to find the char/word spacing (or if orphans have allowed length of line to go over the maxwidth)
		if(( $align == 'J' ) || ($cutoffWidth + $lastitalic > $maxWidth - $WidthCorrection - (($this->cMarginL+$this->cMarginR)*$this->k) - ($paddingL+$paddingR +(($fpaddingL + $fpaddingR) * $this->k) ) +  0.001)) {   // 0.001 is to correct for deviations converting mm=>pts
		  // JUSTIFY J (Use character spacing)
 		  // WORD SPACING
			foreach ( $content as $k => $chunk ) {
		  		if (!isset($this->objectbuffer[$k]) || (isset($this->objectbuffer[$k]) && !$this->objectbuffer[$k])) {
					if ($this->usingCoreFont) {
					      $chunk = str_replace($this->chrs[160],$this->chrs[32],$chunk );
					}
					else {
					      $chunk = str_replace($this->chrs[194].$this->chrs[160],$this->chrs[32],$chunk ); 
					}
					$nb_carac += mb_strlen( $chunk, $this->mb_enc ) ;  
					$nb_spaces += mb_substr_count( $chunk,' ', $this->mb_enc ) ;  
				}
			}
			list($charspacing,$ws) = $this->GetJspacing($nb_carac,$nb_spaces,($maxWidth-$lastitalic-$cutoffWidth-$WidthCorrection-(($this->cMarginL+$this->cMarginR)*$this->k)-($paddingL+$paddingR +(($fpaddingL + $fpaddingR) * $this->k) )));
			$this->SetSpacing($charspacing,$ws);
		}
		// otherwise, we want normal spacing
		else {
			$this->ResetSpacing();
		}

		// WORD SPACING
		$empty = $maxWidth - $lastitalic-$WidthCorrection - $contentWidth - (($this->cMarginL+$this->cMarginR)* $this->k) - ($paddingL+$paddingR +(($fpaddingL + $fpaddingR) * $this->k) ) - ( $this->charspacing * $nb_carac) - ( $this->ws * $nb_spaces);
		$empty /= $this->k;
		$b = ''; //do not use borders
		// Get PAGEBREAK TO TEST for height including the top border/padding
		$check_h = max($this->divheight,$lineHeight);
		if (($newblock) && ($blockstate==1 || $blockstate==3) && ($this->blklvl > 0) && ($lineCount == 1) && (!$is_table) && (!$is_list)) { 
			$check_h += ($this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['border_top']['w']);
		}

		if ($this->ColActive && $check_h > ($this->PageBreakTrigger - $this->y0)) { $this->CurrCol = $this->NbCol; } 

		// PAGEBREAK
		// 'If' below used in order to fix "first-line of other page with justify on" bug 
		if(!$is_table && ($this->y+$check_h) > $this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak()) {
			$bak_x=$this->x;//Current X position

			// WORD SPACING
			$ws=$this->ws;//Word Spacing
			$charspacing=$this->charspacing;//Character Spacing
			$this->ResetSpacing();

		      $this->AddPage($this->CurOrientation);

		      $this->x = $bak_x;
			// Added to correct for OddEven Margins
			$currentx += $this->MarginCorrection;
			$this->x += $this->MarginCorrection;

			// WORD SPACING
			$this->SetSpacing($charspacing,$ws);
		}

		// mPDF 5.0
		if ($this->keep_block_together && !$is_table && $this->kt_p00 < $this->page && ($this->y+$check_h) > $this->kt_y00) {
			$this->printdivbuffer();
			$this->keep_block_together = 0;
		}



		// TOP MARGIN
		if (($newblock) && ($blockstate==1 || $blockstate==3) && ($this->blk[$this->blklvl]['margin_top']) && ($lineCount == 1) && (!$is_table) && (!$is_list)) { 
			$this->DivLn($this->blk[$this->blklvl]['margin_top'],$this->blklvl-1,true,$this->blk[$this->blklvl]['margin_collapse']); 
		}


		// Update y0 for top of block (used to paint border)
		if (($newblock) && ($blockstate==1 || $blockstate==3) && ($lineCount == 1) && (!$is_table) && (!$is_list)) { 
			$this->blk[$this->blklvl]['y0'] = $this->y;
			$this->blk[$this->blklvl]['startpage'] = $this->page;
		}

		// TOP PADDING and BORDER spacing/fill
		if (($newblock) && ($blockstate==1 || $blockstate==3) && (($this->blk[$this->blklvl]['padding_top']) || ($this->blk[$this->blklvl]['border_top'])) && ($lineCount == 1) && (!$is_table) && (!$is_list)) { 
			// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
			$this->DivLn($this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'],-3,true,false,1);
		}

		$arraysize = count($content);

		$margins = ($this->cMarginL+$this->cMarginR) + ($ipaddingL+$ipaddingR + $fpaddingR + $fpaddingR );
 
		// PAINT BACKGROUND FOR THIS LINE
		if (!$is_table) { $this->DivLn($lineHeight,$this->blklvl,false); }	// false -> don't advance y

		$this->x = $currentx + $this->cMarginL + $ipaddingL + $fpaddingL ;
		if ($align == 'R') { $this->x += $empty; }
		else if ($align == 'C') { $this->x += ($empty / 2); }

		// Paragraph INDENT
		if (isset($this->blk[$this->blklvl]['text_indent']) && ($newblock) && ($blockstate==1 || $blockstate==3) && ($lineCount == 1) && (!$is_table) && ($this->directionality!='rtl') && ($align !='C')) { 
			$ti = $this->ConvertSize($this->blk[$this->blklvl]['text_indent'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); 
			$this->x += $ti; 
		}


		// DIRECTIONALITY RTL
		$all_rtl = false;
		$contains_rtl = false;

		foreach ( $content as $k => $chunk ) {

			// FOR IMAGES - UPDATE POSITION
			if (($this->directionality=='rtl' && $contains_rtl) || $all_rtl) { $dirk = $arraysize-1 - $k ; } else { $dirk = $k; }

			$va = 'M';	// default for text
			if (isset($this->objectbuffer[$dirk]) && $this->objectbuffer[$dirk]) {
			  $xadj = $this->x - $this->objectbuffer[$dirk]['OUTER-X'] ; 
			  $this->objectbuffer[$dirk]['OUTER-X'] += $xadj;
			  $this->objectbuffer[$dirk]['BORDER-X'] += $xadj;
			  $this->objectbuffer[$dirk]['INNER-X'] += $xadj;
			  $va = $this->objectbuffer[$dirk]['vertical-align'];
			  $yadj = $this->y - $this->objectbuffer[$dirk]['OUTER-Y'];
			  if ($va == 'BS') { 
				$yadj += $af + ($this->linemaxfontsize * (0.5 + $this->baselineC)) - $this->objectbuffer[$dirk]['OUTER-HEIGHT'];
			  }
			  else if ($va == 'M' || $va == '') { 
				$yadj += $af + ($this->linemaxfontsize /2) - ($this->objectbuffer[$dirk]['OUTER-HEIGHT']/2);
			  }
			  else if ($va == 'TB') { 
				$yadj += $af + $this->linemaxfontsize - $this->objectbuffer[$dirk]['OUTER-HEIGHT'];
			  }
			  else if ($va == 'TT') { 
				$yadj += $af;
			  }
			  else if ($va == 'B') { 
				$yadj += $af + $this->linemaxfontsize + $bf - $this->objectbuffer[$dirk]['OUTER-HEIGHT'];
			  }
			  else if ($va == 'T') { 
				$yadj += 0;
			  }
			  $this->objectbuffer[$dirk]['OUTER-Y'] += $yadj;
			  $this->objectbuffer[$dirk]['BORDER-Y'] += $yadj;
			  $this->objectbuffer[$dirk]['INNER-Y'] += $yadj;
			}

			// DIRECTIONALITY RTL
			if ((($this->directionality == 'rtl') && ($contains_rtl )) || ($all_rtl )) { $this->restoreFont($font[$arraysize-1 - $k]); }
			else { $this->restoreFont( $font[ $k ] ); }

	 		// *********** SPAN BACKGROUND COLOR ***************** //
			if ($this->spanbgcolor) { 
				$cor = $this->spanbgcolorarray;
				$this->SetFillColor($cor['R'],$cor['G'],$cor['B']);
				$save_fill = $fill; $spanfill = 1; $fill = 1;
			}

			// WORD SPACING
		      $stringWidth = $this->GetStringWidth($chunk ) + ( $this->charspacing * mb_strlen($chunk,$this->mb_enc ) / $this->k )  
				+ ( $this->ws * mb_substr_count($chunk,' ',$this->mb_enc ) / $this->k );
			if (isset($this->objectbuffer[$dirk])) { $stringWidth = $this->objectbuffer[$dirk]['OUTER-WIDTH'];  }

			if ($stringWidth==0) { $stringWidth = 0.000001; }	// mPDF 5.0
			if ($k == $arraysize-1) {
				$stringWidth -= ( $this->charspacing / $this->k ); 
				$this->Cell( $stringWidth, $lineHeight, $chunk, '', 1, '', $fill, $this->HREF , $currentx,0,0,'M', $fill, $af, $bf ); //mono-style line or last part (skips line)
			}
			else $this->Cell( $stringWidth, $lineHeight, $chunk, '', 0, '', $fill, $this->HREF, 0, 0,0,'M', $fill, $af, $bf );//first or middle part


	 		// *********** SPAN BACKGROUND COLOR OFF - RESET BLOCK BGCOLOR ***************** //
			if (isset($spanfill) && $spanfill) { 
				$fill = $save_fill; $spanfill = 0; 
				if ($fill) { $this->SetFillColor($bcor['R'],$bcor['G'],$bcor['B']); }
			}
		}
		if (!$is_table) { 
			$this->maxPosR = max($this->maxPosR , ($this->w - $this->rMargin - $this->blk[$this->blklvl]['outer_right_margin'])); 
			$this->maxPosL = min($this->maxPosL , ($this->lMargin + $this->blk[$this->blklvl]['outer_left_margin'])); 
		}

		// move on to the next line, reset variables, tack on saved content and current char

		$this->printobjectbuffer($is_table);
		$this->objectbuffer = array();




		// Reset lineheight
		$lineHeight = $this->divheight;
		$valign = 'M';

		$this->restoreFont( $savedFont );

		$font = array();
		$content = array();

		$contentWidth = 0;
		if (!empty($savedObj)) {
			$this->objectbuffer[] = $savedObj;
			$font[] = $savedFont;
			$content[] = '';
			$contentWidth += $savedObj['OUTER-WIDTH'] * $this->k;
		}
		$font[] = $savedFont;
		$content[] = $savedContent . $c;
		$currContent =& $content[ (count($content)-1) ];
		$contentWidth += $this->GetStringWidth( $currContent ) * $this->k;
		$cutoffWidth = $contentWidth;
      }
      // another character will fit, so add it on
	else {
		$contentWidth += $cw;
		$currContent .= $c;
	}
    }
    unset($content);
}
//----------------------END OF FLOWING BLOCK------------------------------------//





////////////////////////////////////////////////////////////////////////////////
// ADDED forcewrap - to call from inline OBJECT functions to breakwords if necessary in cell
////////////////////////////////////////////////////////////////////////////////
function WordWrap(&$text, $maxwidth, $forcewrap = 0) {
    $biggestword=0;
    $toonarrow=false;

    $text = trim($text);

    if ($text==='') return 0;
    $space = $this->GetStringWidth(' ');
    $lines = explode("\n", $text);
    $text = '';
    $count = 0;
    foreach ($lines as $line) {
	$words = explode(' ', $line);
	$width = 0;
	foreach ($words as $word) {
		$word = trim($word);
		$wordwidth = $this->GetStringWidth($word);

		//Warn user that maxwidth is insufficient
		if ($wordwidth > $maxwidth + 0.0001) {
			if ($wordwidth > $biggestword) { $biggestword = $wordwidth; }
			$toonarrow=true;
			// ADDED
			if ($forcewrap) {
			  while($wordwidth > $maxwidth) {
				$chw = 0;	// check width
				for ( $i = 0; $i < mb_strlen($word, $this->mb_enc ); $i++ ) {
					$chw = $this->GetStringWidth(mb_substr($word,0,$i+1,$this->mb_enc ));
					if ($chw > $maxwidth ) {
						if ($text) {
							$text = rtrim($text)."\n".mb_substr($word,0,$i,$this->mb_enc );
							$count++;
						}
						else {
							$text = mb_substr($word,0,$i,$this->mb_enc );
						}
						$word = mb_substr($word,$i,mb_strlen($word, $this->mb_enc )-$i,$this->mb_enc );
						$wordwidth = $this->GetStringWidth($word);
						$width = $maxwidth; 
						break;
					}
				}
			  }
			}
		}

		if ($width + $wordwidth  < $maxwidth - 0.0001) {
			$width += $wordwidth + $space;
			$text .= $word.' ';
		}
		else {
			$width = $wordwidth + $space;
			$text = rtrim($text)."\n".$word.' ';
			$count++;
            }
	}

	$text = rtrim($text)."\n";
	$count++;
    }
    $text = rtrim($text);

    //Return -(wordsize) if word is bigger than maxwidth 

	// ADDED
	if ($forcewrap) { return $count; }
      if (($toonarrow) && ($this->table_error_report)) {
		$this->Error("Word is too long to fit in table - ".$this->table_error_report_param); 
	}
    if ($toonarrow) return -$biggestword;
    else return $count;
}

function _SetTextRendering($mode) { 
	if (!(($mode == 0) || ($mode == 1) || ($mode == 2))) 
	$this->Error("Text rendering mode should be 0, 1 or 2 (value : $mode)"); 
	$tr = ($mode.' Tr'); 
	if($this->page>0 && ((isset($this->pageoutput[$this->page]['TextRendering']) && $this->pageoutput[$this->page]['TextRendering'] != $tr) || !isset($this->pageoutput[$this->page]['TextRendering']) || $this->keep_block_together)) { $this->_out($tr); }
	$this->pageoutput[$this->page]['TextRendering'] = $tr;

} 

function SetTextOutline($width, $r=0, $g=-1, $b=-1) { 
  if ($width == false) //Now resets all values
  { 
    $this->outline_on = false;
    $this->SetLineWidth(0.2); 
    $this->SetDrawColor(0); 
    $this->_SetTextRendering(0); 
    $tr = ('0 Tr'); 
	if($this->page>0 && ((isset($this->pageoutput[$this->page]['TextRendering']) && $this->pageoutput[$this->page]['TextRendering'] != $tr) || !isset($this->pageoutput[$this->page]['TextRendering']) || $this->keep_block_together)) { $this->_out($tr); }
	$this->pageoutput[$this->page]['TextRendering'] = $tr;
  }
  else
  { 
    $this->SetLineWidth($width); 
    $this->SetDrawColor($r, $g , $b); 
    $tr = ('2 Tr'); 
	if($this->page>0 && ((isset($this->pageoutput[$this->page]['TextRendering']) && $this->pageoutput[$this->page]['TextRendering'] != $tr) || !isset($this->pageoutput[$this->page]['TextRendering']) || $this->keep_block_together)) { $this->_out($tr); }
	$this->pageoutput[$this->page]['TextRendering'] = $tr;
  } 
}

function Image($file,$x,$y,$w=0,$h=0,$type='',$link='',$paint=true, $constrain=true, $watermark=false, $shownoimg=true, $allowvector=true) {
	$orig_srcpath = $file;
	$this->GetFullPath($file);

	$info=$this->_getImage($file, true, $allowvector, $orig_srcpath );
	if(!$info && $paint) {
		$info = $this->_getImage($this->noImageFile);
		if ($info) { 
			$file = $this->noImageFile; 
			$w = ($info['w'] * (25.4/$this->dpi)); 	// 14 x 16px
			$h = ($info['h'] * (25.4/$this->dpi)); 	// 14 x 16px
		}
	}
	if(!$info) return false;
	//Automatic width and height calculation if needed
	if($w==0 and $h==0) {
           if ($info['type']=='svg') { 
			// returned SVG units are pts
			// divide by k to get user units (mm)
			$w = abs($info['w'])/$this->k;
			$h = abs($info['h']) /$this->k;
		}
		else {
			//Put image at default image dpi
			$w=($info['w']/$this->k) * (72/$this->img_dpi);
			$h=($info['h']/$this->k) * (72/$this->img_dpi);
		}
	}
	if($w==0)	$w=abs($h*$info['w']/$info['h']); 
	if($h==0)	$h=abs($w*$info['h']/$info['w']); 


	if ($constrain) {
	  // Automatically resize to maximum dimensions of page if too large
	  if (isset($this->blk[$this->blklvl]['inner_width']) && $this->blk[$this->blklvl]['inner_width']) { $maxw = $this->blk[$this->blklvl]['inner_width']; }
	  else { $maxw = $this->pgwidth; }
	  if ($w > $maxw) {
		$w = $maxw;
		$h=abs($w*$info['h']/$info['w']);
	  }
	  if ($h > $this->h - ($this->tMargin + $this->bMargin + 10))  {  // see below - +10 to avoid drawing too close to border of page
   		$h = $this->h - ($this->tMargin + $this->bMargin + 10) ;
		if ($this->fullImageHeight) { $h = $this->fullImageHeight; }
		$w=abs($h*$info['w']/$info['h']);
	  }


	  //Avoid drawing out of the paper(exceeding width limits).
	  //if ( ($x + $w) > $this->fw ) {
	  if ( ($x + $w) > $this->w ) {
		$x = $this->lMargin;
		$y += 5;
	  }

	  $changedpage = false;
	  $oldcolumn = $this->CurrCol;
	  //Avoid drawing out of the page.
	  if($y+$h>$this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak()) {
		$this->AddPage($this->CurOrientation);
		// Added to correct for OddEven Margins
		$x=$x +$this->MarginCorrection;
		$y = $tMargin + $this->margin_header;
		$changedpage = true;
	  }
	}	// end of IF constrain

	if ($info['type']=='svg') { 
		$sx = $w*$this->k / $info['w'];
		$sy = -$h*$this->k / $info['h'];
		$outstring = sprintf('q %.3f 0 0 %.3f %.3f %.3f cm /FO%d Do Q', $sx, $sy, $x*$this->k-$sx*$info['x'], (($this->h-$y)*$this->k)-$sy*$info['y'], $info['i']);
	}
	else { 
		$outstring = sprintf("q %.3f 0 0 %.3f %.3f %.3f cm /I%d Do Q",$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i']);
	}

	if($paint) {
		$this->_out($outstring);
		if($link) $this->Link($x,$y,$w,$h,$link);

		// Avoid writing text on top of the image. // THIS WAS OUTSIDE THE if ($paint) bit!!!!!!!!!!!!!!!!
		$this->y = $y + $h;
	}

	//Return width-height array
	$sizesarray['WIDTH'] = $w;
	$sizesarray['HEIGHT'] = $h;
	$sizesarray['X'] = $x; //Position before painting image
	$sizesarray['Y'] = $y; //Position before painting image
	$sizesarray['OUTPUT'] = $outstring;

	$sizesarray['IMAGE_ID'] = $info['i'];
	return $sizesarray;
}



//=============================================================
//=============================================================
//=============================================================
//=============================================================
//=============================================================
function _getObjAttr($t) {
	$c = explode("\xbb\xa4\xac",$t,2);
	$c = explode(",",$c[1],2);
	foreach($c as $v) {
		$v = explode("=",$v,2);
		$sp[$v[0]] = $v[1];
	}
	return (unserialize($sp['objattr']));
}


function inlineObject($type,$x,$y,$objattr,$Lmargin,$widthUsed,$maxWidth,$lineHeight,$paint=false,$is_table=false)
{
   if ($is_table) { $k = $this->shrin_k; } else { $k = 1; }

   // NB $x is only used when paint=true
	// Lmargin not used
   $w = 0; 
   if (isset($objattr['width'])) { $w = $objattr['width']/$k; }
   $h = 0;
   if (isset($objattr['height'])) { $h = abs($objattr['height']/$k); }
   $widthLeft = $maxWidth - $widthUsed;
   $maxHeight = $this->h - ($this->tMargin + $this->bMargin + 10) ;
   if ($this->fullImageHeight) { $maxHeight = $this->fullImageHeight; }
   // For Images
   if (isset($objattr['border_left'])) {
	$extraWidth = ($objattr['border_left']['w'] + $objattr['border_right']['w'] + $objattr['margin_left']+ $objattr['margin_right'])/$k;
	$extraHeight = ($objattr['border_top']['w'] + $objattr['border_bottom']['w'] + $objattr['margin_top']+ $objattr['margin_bottom'])/$k;

	if ($type == 'image' || $type == 'barcode') {
		$extraWidth += ($objattr['padding_left'] + $objattr['padding_right'])/$k;
		$extraHeight += ($objattr['padding_top'] + $objattr['padding_bottom'])/$k;
	}
   }

   if (!isset($objattr['vertical-align'])) { $objattr['vertical-align'] = 'M'; }

   if ($type == 'image' || (isset($objattr['subtype']) && $objattr['subtype'] == 'IMAGE')) {
    if (isset($objattr['itype']) && ($objattr['itype'] == 'wmf' || $objattr['itype'] == 'svg')) {
	$file = $objattr['file'];
 	$info=$this->formobjects[$file];
    }
    else if (isset($objattr['file'])) {
	$file = $objattr['file'];
	$info=$this->images[$file];
    }
   }
    if ($type == 'annot' || $type == 'bookmark' || $type == 'indexentry' || $type == 'toc') {
	$w = 0.00001;
	$h = 0.00001;
   }

   // TEST whether need to skipline
   if (!$paint) {
	if ($type == 'hr') {	// always force new line
		if (($y + $h + $lineHeight > $this->PageBreakTrigger) && !$this->InFooter && !$is_table) { return array(-2, $w ,$h ); } // New page + new line
		else { return array(1, $w ,$h ); } // new line
	}
	else {
		if ($widthUsed > 0 && $w > $widthLeft && (!$is_table || $type != 'image')) { 	// New line needed
			if (($y + $h + $lineHeight > $this->PageBreakTrigger) && !$this->InFooter) { return array(-2,$w ,$h ); } // New page + new line
			return array(1,$w ,$h ); // new line
		}
		else if ($widthUsed > 0 && $w > $widthLeft && $is_table) { 	// New line needed in TABLE
			return array(1,$w ,$h ); // new line
		}
		// Will fit on line but NEW PAGE REQUIRED
		else if (($y + $h > $this->PageBreakTrigger) && !$this->InFooter && !$is_table) { return array(-1,$w ,$h ); }
		else { return array(0,$w ,$h ); }
	}
   }

   if ($type == 'annot' || $type == 'bookmark' || $type == 'indexentry' || $type == 'toc') {
	$w = 0.00001;
	$h = 0.00001;
	$objattr['BORDER-WIDTH'] = 0;
	$objattr['BORDER-HEIGHT'] = 0;
	$objattr['BORDER-X'] = $x;
	$objattr['BORDER-Y'] = $y;
	$objattr['INNER-WIDTH'] = 0;
	$objattr['INNER-HEIGHT'] = 0;
	$objattr['INNER-X'] = $x;
	$objattr['INNER-Y'] = $y;
  }

  if ($type == 'image') {
	// Automatically resize to width remaining
	if ($w > $widthLeft  && !$is_table) {
		$w = $widthLeft ;
		$h=abs($w*$info['h']/$info['w']);
	}
	$img_w = $w - $extraWidth ;
	$img_h = $h - $extraHeight ;

	$objattr['BORDER-WIDTH'] = $img_w + $objattr['padding_left']/$k + $objattr['padding_right']/$k + (($objattr['border_left']['w']/$k + $objattr['border_right']['w']/$k)/2) ;
	$objattr['BORDER-HEIGHT'] = $img_h + $objattr['padding_top']/$k + $objattr['padding_bottom']/$k + (($objattr['border_top']['w']/$k + $objattr['border_bottom']['w']/$k)/2) ;
	$objattr['BORDER-X'] = $x + $objattr['margin_left']/$k + (($objattr['border_left']['w']/$k)/2) ;
	$objattr['BORDER-Y'] = $y + $objattr['margin_top']/$k + (($objattr['border_top']['w']/$k)/2) ;
	$objattr['INNER-WIDTH'] = $img_w;
	$objattr['INNER-HEIGHT'] = $img_h;
	$objattr['INNER-X'] = $x + $objattr['padding_left']/$k + $objattr['margin_left']/$k + ($objattr['border_left']['w']/$k);
	$objattr['INNER-Y'] = $y + $objattr['padding_top']/$k + $objattr['margin_top']/$k + ($objattr['border_top']['w']/$k) ;
	$objattr['ID'] = $info['i'];
   }

   if ($type == 'input' && $objattr['subtype'] == 'IMAGE') { 
	$img_w = $w - $extraWidth ;
	$img_h = $h - $extraHeight ;
	$objattr['BORDER-WIDTH'] = $img_w + (($objattr['border_left']['w']/$k + $objattr['border_right']['w']/$k)/2) ;
	$objattr['BORDER-HEIGHT'] = $img_h + (($objattr['border_top']['w']/$k + $objattr['border_bottom']['w']/$k)/2) ;
	$objattr['BORDER-X'] = $x + $objattr['margin_left']/$k + (($objattr['border_left']['w']/$k)/2) ;
	$objattr['BORDER-Y'] = $y + $objattr['margin_top']/$k + (($objattr['border_top']['w']/$k)/2) ;
	$objattr['INNER-WIDTH'] = $img_w;
	$objattr['INNER-HEIGHT'] = $img_h;
	$objattr['INNER-X'] = $x + $objattr['margin_left']/$k + ($objattr['border_left']['w']/$k);
	$objattr['INNER-Y'] = $y + $objattr['margin_top']/$k + ($objattr['border_top']['w']/$k) ;
	$objattr['ID'] = $info['i'];
   }



   if ($type == 'textarea') {
	// Automatically resize to width remaining
	if ($w > $widthLeft && !$is_table) {
		$w = $widthLeft ;
	}
	if (($y + $h > $this->PageBreakTrigger) && !$this->InFooter) {
		$h=$this->h - $y - $this->bMargin;
	}
   }

   if ($type == 'hr') {
	if ($is_table) { 
		$objattr['INNER-WIDTH'] = $maxWidth * $objattr['W-PERCENT']/100; 
		$objattr['width'] = $objattr['INNER-WIDTH']; 
		$w = $maxWidth;
	}
	else { 
		if ($w>$maxWidth) { $w = $maxWidth; }
		$objattr['INNER-WIDTH'] = $w; 
		$w = $maxWidth;
	}
  }



   if (($type == 'select') || ($type == 'input' && ($objattr['subtype'] == 'TEXT' || $objattr['subtype'] == 'PASSWORD'))) {
	// Automatically resize to width remaining
	if ($w > $widthLeft && !$is_table) {
		$w = $widthLeft;
	}
   }

   if ($type == 'textarea' || $type == 'select' || $type == 'input') {
	if (isset($objattr['fontsize'])) $objattr['fontsize'] /= $k;
	if (isset($objattr['linewidth'])) $objattr['linewidth'] /= $k;
   }

   if (!isset($objattr['BORDER-Y'])) { $objattr['BORDER-Y'] = 0; }
   if (!isset($objattr['BORDER-X'])) { $objattr['BORDER-X'] = 0; }
   if (!isset($objattr['INNER-Y'])) { $objattr['INNER-Y'] = 0; }
   if (!isset($objattr['INNER-X'])) { $objattr['INNER-X'] = 0; }

   //Return width-height array
   $objattr['OUTER-WIDTH'] = $w;
   $objattr['OUTER-HEIGHT'] = $h;
   $objattr['OUTER-X'] = $x;
   $objattr['OUTER-Y'] = $y;
   return $objattr;
}


//=============================================================
//=============================================================
//=============================================================
//=============================================================
//=============================================================




function SetDash($black=false,$white=false)
{
        if($black and $white) $s=sprintf('[%.3f %.3f] 0 d',$black*$this->k,$white*$this->k);
        else $s='[] 0 d';
	if($this->page>0 && ((isset($this->pageoutput[$this->page]['Dash']) && $this->pageoutput[$this->page]['Dash'] != $s) || !isset($this->pageoutput[$this->page]['Dash']) || $this->keep_block_together)) { $this->_out($s); }
	$this->pageoutput[$this->page]['Dash'] = $s;

}

function SetDisplayPreferences($preferences) {
	// String containing any or none of /HideMenubar/HideToolbar/HideWindowUI/DisplayDocTitle/CenterWindow/FitWindow
    $this->DisplayPreferences .= $preferences;
}


function Ln($h='',$collapsible=0)
{
// Added collapsible to allow collapsible top-margin on new page
	//Line feed; default value is last cell height
	$this->x = $this->lMargin + $this->blk[$this->blklvl]['outer_left_margin'];
	if ($collapsible && ($this->y==$this->tMargin) && (!$this->ColActive)) { $h = 0; }
	if(is_string($h)) $this->y+=$this->lasth;
	else $this->y+=$h;
}


// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
function DivLn($h,$level=-3,$move_y=true,$collapsible=false,$state=0) {
  // this->x is returned as it was
  // adds lines (y) where DIV bgcolors are filled in
  // allows .00001 as nominal height used for bookmarks/annotations etc.
  if ($collapsible && (sprintf("%0.4f", $this->y)==sprintf("%0.4f", $this->tMargin)) && (!$this->ColActive)) { return; }

	// Still use this method if columns or page-break-inside: avoid, as it allows repositioning later
	// otherwise, now uses PaintDivBB()
  if (!$this->ColActive && !$this->keep_block_together && !$this->kwt) {
	if ($move_y && !$this->ColActive) { $this->y += $h; }
	return; 
  }

  if ($level == -3) { $level = $this->blklvl; }
  $firstblockfill = $this->GetFirstBlockFill();
  if ($firstblockfill && $this->blklvl > 0 && $this->blklvl >= $firstblockfill) {
	$last_x = 0;
	$last_w = 0;
	$last_fc = $this->FillColor;
	$bak_x = $this->x;
	$bak_h = $this->divheight;
	$this->divheight = 0;	// Temporarily turn off divheight - as Cell() uses it to check for PageBreak
	for ($blvl=$firstblockfill;$blvl<=$level;$blvl++) {
		$this->SetBlockFill($blvl);
		$this->x = $this->lMargin + $this->blk[$blvl]['outer_left_margin'];
		if ($last_x != $this->lMargin + $this->blk[$blvl]['outer_left_margin'] || $last_w != $this->blk[$blvl]['width'] || $last_fc != $this->FillColor) {
			$x = $this->x;
			$this->Cell( ($this->blk[$blvl]['width']), $h, '', '', 0, '', 1);
			if (!$this->keep_block_together && !$this->writingHTMLheader && !$this->writingHTMLfooter) {
				$this->x = $x;
				// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
				if ($blvl == $this->blklvl) { $this->PaintDivLnBorder($state,$blvl,$h); }
				else { $this->PaintDivLnBorder(0,$blvl,$h); }
			}
		}
		$last_x = $this->lMargin + $this->blk[$blvl]['outer_left_margin'];
		$last_w = $this->blk[$blvl]['width'];
		$last_fc = $this->FillColor;
	}
	// Reset current block fill
	if (isset($this->blk[$this->blklvl]['bgcolorarray'])) { 
		$bcor = $this->blk[$this->blklvl]['bgcolorarray'];
		$this->SetFillColor($bcor['R'],$bcor['G'],$bcor['B']);
	}
	$this->x = $bak_x;
	$this->divheight = $bak_h;
  }
  if ($move_y) { $this->y += $h; }
}

function GetX()
{
	//Get x position
	return $this->x;
}

function SetX($x)
{
	//Set x position
	if($x >= 0)	$this->x=$x;
	else $this->x = $this->w + $x;
}

function GetY()
{
	//Get y position
	return $this->y;
}

function SetY($y)
{
	//Set y position and reset x
	$this->x=$this->lMargin;
	if($y>=0)
		$this->y=$y;
	else
		$this->y=$this->h+$y;
}

function SetXY($x,$y)
{
	//Set x and y positions
	$this->SetY($y);
	$this->SetX($x);
}



function Output($name='',$dest='')
{
	//Output PDF to some destination
	global $_SERVER;

	if ($this->showStats) {
		echo '<div>Generated in '.sprintf('%.2f',(microtime(true) - $this->time0)).' seconds</div>';
	}
	//Finish document if necessary
	if ($this->progressBar) { $this->UpdateProgressBar(1,'100','Finished'); }
	if($this->state < 3) $this->Close();
	if ($this->progressBar) { $this->UpdateProgressBar(2,'100','Finished'); }
	// fn. error_get_last is only in PHP>=5.2
	if ($this->debug && function_exists('error_get_last') && error_get_last()) {
	   $e = error_get_last(); 
	   if (($e['type'] < 2048 && $e['type'] != 8) || (intval($e['type']) & intval(ini_get("error_reporting")))) {
		echo "<p>Error message detected - PDF file generation aborted.</p>"; 
		echo $e['message'].'<br />';
		echo 'File: '.$e['file'].'<br />';
		echo 'Line: '.$e['line'].'<br />';
		exit; 
	   }
	}


	if ($this->PDFA && $this->encrypted) { $this->Error("PDFA1-b does not permit encryption of documents."); }
	if (count($this->PDFAwarnings) && $this->PDFA && !$this->PDFAauto) {
		echo '<div>WARNING - This file could not be generated as it stands as a PDFA1-b compliant file.</div>';
		echo '<div>These issues can be automatically fixed by mPDF using <i>$mpdf-&gt;PDFAauto=true;</i></div>';
		echo '<div>Action that mPDF will take to automatically force PDFA1-b compliance are shown in brackets.</div>';
		echo '<div>Warning(s) generated:</div><ul>';
		foreach($this->PDFAwarnings AS $w) {
			echo '<li>'.$w.'</li>';
		}
		echo '</ul>';
		exit;
	}


	if ($this->showStats) {
		echo '<div>Compiled in '.sprintf('%.2f',(microtime(true) - $this->time0)).' seconds (total)</div>';
		echo '<div>Peak Memory usage '.number_format((memory_get_peak_usage(true)/(1024*1024)),2).' MB</div>';
		echo '<div>PDF file size '.number_format((strlen($this->buffer)/1024)).' kB</div>';
		echo '<div>Number of fonts '.count($this->fonts).'</div>';
		exit;
	}

	if(is_bool($dest)) $dest=$dest ? 'D' : 'F';
	$dest=strtoupper($dest);
	if($dest=='') {
		if($name=='') {
			$name='mpdf.pdf';
			$dest='I';
		}
		else { $dest='F'; }
	}


	if ($this->progressBar && ($dest=='D' || $dest=='I')) {
		if($name=='') { $name='mpdf.pdf'; }
		$tempfile = '_tempPDF'.RAND(1,10000);
		//Save to local file
		$f=fopen(_MPDF_TEMP_PATH.$tempfile.'.pdf','wb');
		if(!$f) $this->Error('Unable to create temporary output file: '.$tempfile.'.pdf');
		fwrite($f,$this->buffer,strlen($this->buffer));
		fclose($f);
		$this->UpdateProgressBar(3,'','Finished');

		echo '<script type="text/javascript">

		var form = document.createElement("form");
		form.setAttribute("method", "post");
		form.setAttribute("action", "'._MPDF_URI.'includes/out.php");

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "filename");
		hiddenField.setAttribute("value", "'.$tempfile.'");
		form.appendChild(hiddenField);

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "dest");
		hiddenField.setAttribute("value", "'.$dest.'");
		form.appendChild(hiddenField);

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "opname");
		hiddenField.setAttribute("value", "'.$name.'");
		form.appendChild(hiddenField);

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "path");
		hiddenField.setAttribute("value", "'.urlencode(_MPDF_TEMP_PATH).'");
		form.appendChild(hiddenField);

		document.body.appendChild(form); 
		form.submit();

      	</script>
		</div>
		</body>
		</html>';
		exit;
	}
	else {
		if ($this->progressBar) { $this->UpdateProgressBar(3,'','Finished'); }

		switch($dest) {
		   case 'I':
			if ($this->debug && !$this->allow_output_buffering && ob_get_contents()) { echo "<p>Output has already been sent from the script - PDF file generation aborted.</p>"; exit; }
			//Send to standard output
			if(isset($_SERVER['SERVER_NAME']))
			{
				//We send to a browser
				header('Content-Type: application/pdf');
				if(headers_sent())
					$this->Error('Some data has already been output to browser, can\'t send PDF file');
				header('Content-Length: '.strlen($this->buffer));
				header('Content-disposition: inline; filename="'.$name.'"');
				// NEW OUTPUT HEADERS  mPDF 5.0
				header('Cache-Control: public, must-revalidate, max-age=0'); 
				header('Pragma: public');
				header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); 
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
/*
				header('Pragma: no-cache');
				header('Cache-Control: maxage=0');
*/
			}
			echo $this->buffer;
			break;
		   case 'D':
			//Download file
			header('Content-Description: File Transfer');
			if (headers_sent())
				$this->Error('Some data has already been output to browser, can\'t send PDF file');
			// NEW OUTPUT HEADERS  mPDF 5.0
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: public, must-revalidate, max-age=0');
			header('Pragma: public');
			header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
			header('Content-Type: application/force-download');
			header('Content-Type: application/octet-stream', false);
			header('Content-Type: application/download', false);
			header('Content-Type: application/pdf', false);
/*
			if(isset($_SERVER['HTTP_USER_AGENT']) and strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')) {
				if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
					header('HTTP/1.1 200 OK');
					header('Status: 200 OK');
					header('Pragma: anytextexeptno-cache', true);
					header("Cache-Control: public, must-revalidate");
				} 
				else {
					header('Pragma: no-cache');
					header('Cache-Control: maxage=0');
				}
				header('Content-Type: application/force-download');
			}
			else {
				header('Content-Type: application/octet-stream');
			}
*/

			header('Content-Length: '.strlen($this->buffer));
			header('Content-disposition: attachment; filename="'.$name.'"');
 			echo $this->buffer;
			break;
		   case 'F':
			//Save to local file
			$f=fopen($name,'wb');
			if(!$f) $this->Error('Unable to create output file: '.$name);
			fwrite($f,$this->buffer,strlen($this->buffer));
			fclose($f);
			break;
		   case 'S':
			//Return as a string
			return $this->buffer;
		   default:
			$this->Error('Incorrect output destination: '.$dest);
		}

	}

	return '';
}


// *****************************************************************************
//                                                                             *
//                             Protected methods                               *
//                                                                             *
// *****************************************************************************
function _dochecks()
{
	//Check for locale-related bug
	if(1.1==1)
		$this->Error('Don\'t alter the locale before including class file');
	//Check for decimal separator
	if(sprintf('%.1f',1.0)!='1.0')
		setlocale(LC_NUMERIC,'C');
}

function _begindoc()
{
	//Start document
	$this->state=1;
	$this->_out('%PDF-'.$this->pdf_version);
	$this->_out('%'.chr(226).chr(227).chr(207).chr(211));	// 4 chars > 128 to show binary file
}


function _puthtmlheaders() {
	$this->state=2;
	$nb=$this->page;
	for($n=1;$n<=$nb;$n++) {
	  if ($this->mirrorMargins && $n%2==0) { $OE = 'E'; }	// EVEN
	  else { $OE = 'O'; }
	  $this->page = $n;
	  if (isset($this->saveHTMLHeader[$n][$OE])) {
		$html = $this->saveHTMLHeader[$n][$OE]['html'];
		$this->lMargin = $this->saveHTMLHeader[$n][$OE]['ml'];
		$this->rMargin = $this->saveHTMLHeader[$n][$OE]['mr'];
		$this->tMargin = $this->saveHTMLHeader[$n][$OE]['mh'];
		$this->bMargin = $this->saveHTMLHeader[$n][$OE]['mf'];
		$this->margin_header = $this->saveHTMLHeader[$n][$OE]['mh'];
		$this->margin_footer = $this->saveHTMLHeader[$n][$OE]['mf'];
		$this->w = $this->saveHTMLHeader[$n][$OE]['pw'];
		$this->h = $this->saveHTMLHeader[$n][$OE]['ph'];
		$rotate = $this->saveHTMLHeader[$n][$OE]['rotate'];
		$this->Reset();
		$this->pageoutput[$n] = array();
		$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
		$this->x = $this->lMargin;
		$this->y = $this->margin_header;

		$html = str_replace('{PAGENO}',$this->pagenumPrefix.$this->docPageNum($n).$this->pagenumSuffix,$html);
		$html = str_replace($this->aliasNbPgGp,$this->nbpgPrefix.$this->docPageNumTotal($n).$this->nbpgSuffix,$html );	// {nbpg}
		$html = str_replace($this->aliasNbPg,$nb,$html );	// {nb}
		$html = preg_replace('/\{DATE\s+(.*?)\}/e',"date('\\1')",$html );

		$this->HTMLheaderPageLinks = array();
		$this->pageBackgrounds = array();

		$this->writingHTMLheader = true;
		$this->WriteHTML($html , 4);	// parameter 4 saves output to $this->headerbuffer
		$this->writingHTMLheader = false;
		$this->Reset();
		$this->pageoutput[$n] = array();

		$s = $this->PrintPageBackgrounds();
		$this->headerbuffer = $s . $this->headerbuffer;

		$os = '';
		if ($rotate) {
			$os .= sprintf('q 0 -1 1 0 0 %.3f cm ',($this->w*$this->k));
		}
		$os .= $this->headerbuffer ;
		if ($rotate) {
			$os .= ' Q' . "\n";
		}

		// Writes over the page background but behind any other output on page
		$os = preg_replace('/\\\\/','\\\\\\\\',$os);
		$this->pages[$n] = preg_replace('/(___HEADER___MARKER'.date('jY').')/', "\n".$os."\n".'\\1', $this->pages[$n]);

		$lks = $this->HTMLheaderPageLinks; 
		foreach($lks AS $lk) {
			if ($rotate) {
				$lw = $lk[2];
				$lh = $lk[3];
				$lk[2] = $lh;
				$lk[3] = $lw;	// swap width and height
				$ax = $lk[0]/$this->k;
				$ay = $lk[1]/$this->k;
				$bx = $ay-($lh/$this->k);
				$by = $this->w-$ax;
				$lk[0] = $bx*$this->k;
				$lk[1] = ($this->h-$by)*$this->k - $lw;
			}
			$this->PageLinks[$n][]=$lk;
		}


	  }
	  if (isset($this->saveHTMLFooter[$n][$OE])) {
		$html = $this->saveHTMLFooter[$this->page][$OE]['html'];
		$this->lMargin = $this->saveHTMLFooter[$n][$OE]['ml'];
		$this->rMargin = $this->saveHTMLFooter[$n][$OE]['mr'];
		$this->tMargin = $this->saveHTMLFooter[$n][$OE]['mh'];
		$this->bMargin = $this->saveHTMLFooter[$n][$OE]['mf'];
		$this->margin_header = $this->saveHTMLFooter[$n][$OE]['mh'];
		$this->margin_footer = $this->saveHTMLFooter[$n][$OE]['mf'];
		$this->w = $this->saveHTMLFooter[$n][$OE]['pw'];
		$this->h = $this->saveHTMLFooter[$n][$OE]['ph'];
		$rotate = $this->saveHTMLFooter[$n][$OE]['rotate'];
		$this->Reset();
		$this->pageoutput[$n] = array();
		$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
		$this->x = $this->lMargin;
		$top_y = $this->y = $this->h - $this->margin_footer;

		// if bottom-margin==0, corrects to avoid division by zero
		if ($this->y == $this->h) { $top_y = $this->y = ($this->h - 0.1); }

		$html = str_replace('{PAGENO}',$this->pagenumPrefix.$this->docPageNum($n).$this->pagenumSuffix,$html);
		$html = str_replace($this->aliasNbPgGp,$this->nbpgPrefix.$this->docPageNumTotal($n).$this->nbpgSuffix,$html );	// {nbpg}
		$html = str_replace($this->aliasNbPg,$nb,$html );	// {nb}
		$html = preg_replace('/\{DATE\s+(.*?)\}/e',"date('\\1')",$html );


		$this->HTMLheaderPageLinks = array();
		$this->pageBackgrounds = array();

		$this->writingHTMLfooter = true;
		$this->InFooter = true;
		$this->WriteHTML($html , 4);	// parameter 4 saves output to $this->headerbuffer
		$this->writingHTMLfooter = false;
		$this->InFooter = false;
		$this->Reset();
		$this->pageoutput[$n] = array();

		$fheight = $this->y - $top_y;
		$adj = -$fheight;

		$s = $this->PrintPageBackgrounds(-$adj);
		$this->headerbuffer = $s . $this->headerbuffer;

		$os = '';
		$os .= $this->StartTransform(true)."\n";
		if ($rotate) {
			$os .= sprintf('q 0 -1 1 0 0 %.3f cm ',($this->w*$this->k));
		}
		$os .= $this->transformTranslate(0, $adj, true)."\n";
		$os .= $this->headerbuffer ;
		if ($rotate) {
			$os .= ' Q' . "\n";
		}
		$os .= $this->StopTransform(true)."\n";
		// Writes over the page background but behind any other output on page
		$os = preg_replace('/\\\\/','\\\\\\\\',$os);
		$this->pages[$n] = preg_replace('/(___HEADER___MARKER'.date('jY').')/', "\n".$os."\n".'\\1', $this->pages[$n]);

		$lks = $this->HTMLheaderPageLinks; 
		foreach($lks AS $lk) {
			$lk[1] -= $adj*$this->k;
			if ($rotate) {
				$lw = $lk[2];
				$lh = $lk[3];
				$lk[2] = $lh;
				$lk[3] = $lw;	// swap width and height

				$ax = $lk[0]/$this->k;
				$ay = $lk[1]/$this->k;
				$bx = $ay-($lh/$this->k);
				$by = $this->w-$ax;
				$lk[0] = $bx*$this->k;
				$lk[1] = ($this->h-$by)*$this->k - $lw;
			}
			$this->PageLinks[$n][]=$lk;
		}
	  }
	}
	$this->page=$nb;
	$this->state=1;
}


function _putpages()
{
	$nb=$this->page;
	$filter=($this->compress) ? '/Filter /FlateDecode ' : '';

	if($this->DefOrientation=='P') {
		$defwPt=$this->fwPt;
		$defhPt=$this->fhPt;
	}
	else {
		$defwPt=$this->fhPt;
		$defhPt=$this->fwPt;
	}
	$annotid=(3+2*$nb);
	for($n=1;$n<=$nb;$n++)
	{
		if(isset($this->OrientationChanges[$n])) { 
			$hPt=$this->pageDim[$n]['w']*$this->k;
			$wPt=$this->pageDim[$n]['h']*$this->k;
		}
		else { 
			$wPt=$this->pageDim[$n]['w']*$this->k;
			$hPt=$this->pageDim[$n]['h']*$this->k;
		}
		//Replace number of pages
		if(!empty($this->aliasNbPg)) {
			// mPDF 5.0
			if (!$this->onlyCoreFonts) { $s1 = $this->UTF8ToUTF16BE($this->aliasNbPg, false); }
			else { $s1 = $this->aliasNbPg; }
			if (!$this->onlyCoreFonts) { $r = $this->UTF8ToUTF16BE($nb, false); }
			else { $r = $nb; }
			if (preg_match_all('/{mpdfheadernbpg (C|R) ff=(\S*) fs=(\S*) fz=(.*?)}/',$this->pages[$n],$m)) {
				for($hi=0;$hi<count($m[0]);$hi++) {
					$pos = $m[1][$hi];
					$hff = $m[2][$hi];
					$hfst = $m[3][$hi];
					$hfsz = $m[4][$hi];
					$this->SetFont($hff,$hfst,$hfsz, false);
					$x1 = $this->GetStringWidth($this->aliasNbPg);
					$x2 = $this->GetStringWidth($nb);
					$xadj = $x1 - $x2;
					if ($pos=='C') { $xadj /= 2; }
					$rep = sprintf(' q 1 0 0 1 %.3f 0 cm ', $xadj*$this->k); 
					$this->pages[$n] = str_replace($m[0][$hi], $rep, $this->pages[$n]);
				}
			}
			$this->pages[$n]=str_replace($s1,$r,$this->pages[$n]);

			// mPDF 5.0.04
			// And now for any SMP/SIP fonts subset using <HH> format
			$r = '';
			$nstr = "$nb";
			for($i=0;$i<strlen($nstr);$i++) {
				$r .= sprintf("%02s", strtoupper(dechex(intval($nstr[$i])+48))); 
			}
			$this->pages[$n]=str_replace($this->aliasNbPgHex,$r,$this->pages[$n]);

		}
		//Replace number of pages in group
		if(!empty($this->aliasNbPgGp)) {
			// mPDF 5.0
			if (!$this->onlyCoreFonts) { $s2 = $this->UTF8ToUTF16BE($this->aliasNbPgGp, false); }
			else { $s2 = $this->aliasNbPgGp; }
			$nbt = $this->docPageNumTotal($n);
			if (!$this->onlyCoreFonts) { $r = $this->UTF8ToUTF16BE($nbt, false); }
			else { $r = $nbt; }
			if (preg_match_all('/{mpdfheadernbpggp (C|R) ff=(\S*) fs=(\S*) fz=(.*?)}/',$this->pages[$n],$m)) {
				for($hi=0;$hi<count($m[0]);$hi++) {
					$pos = $m[1][$hi];
					$hff = $m[2][$hi];
					$hfst = $m[3][$hi];
					$hfsz = $m[4][$hi];
					$this->SetFont($hff,$hfst,$hfsz, false);
					$x1 = $this->GetStringWidth($this->aliasNbPgGp);
					$x2 = $this->GetStringWidth($nbt);
					$xadj = $x1 - $x2;
					if ($pos=='C') { $xadj /= 2; }
					$rep = sprintf(' q 1 0 0 1 %.3f 0 cm ', $xadj*$this->k); 
					$this->pages[$n] = str_replace($m[0][$hi], $rep, $this->pages[$n]);
				}
			}
			$this->pages[$n]=str_replace($s2,$r,$this->pages[$n]);

			// mPDF 5.0.04
			// And now for any SMP/SIP fonts subset using <HH> format
			$r = '';
			$nstr = "$nbt";
			for($i=0;$i<strlen($nstr);$i++) {
				$r .= sprintf("%02s", strtoupper(dechex(intval($nstr[$i])+48))); 
			}
			$this->pages[$n]=str_replace($this->aliasNbPgGpHex,$r,$this->pages[$n]);

		}

		$this->pages[$n] = preg_replace('/(___BACKGROUND___PATTERNS'.date('jY').')/', "\n", $this->pages[$n]);
		$this->pages[$n] = preg_replace('/(___HEADER___MARKER'.date('jY').')/', "\n", $this->pages[$n]);
		$this->pages[$n] = preg_replace('/(___PAGE___START'.date('jY').')/', "\n", $this->pages[$n]);	// mPDF 5.0

		//Page
		$this->_newobj();
		$this->_out('<</Type /Page');
		$this->_out('/Parent 1 0 R');
		if(isset($this->OrientationChanges[$n])) {
			$this->_out(sprintf('/MediaBox [0 0 %.3f %.3f]',$hPt,$wPt));
			if (isset($this->OrientationChanges[$n]) && $this->displayDefaultOrientation) {
				if ($this->DefOrientation=='P') { $this->_out('/Rotate 270'); }
				else { $this->_out('/Rotate 90'); }
			}
		}
		else if($wPt != $defwPt || $hPt != $defhPt) {
			$this->_out(sprintf('/MediaBox [0 0 %.3f %.3f]',$wPt,$hPt));
		}
		$this->_out('/Resources 2 0 R');

		$annotsnum = 0;
		if (isset($this->PageLinks[$n])) { $annotsnum += count($this->PageLinks[$n]); }
		if ($annotsnum ) {
			$s = '/Annots [ ';
			for($i=0;$i<$annotsnum;$i++) { 
				$s .= ($annotid + $i) . ' 0 R ';
			} 
			$annotid += $annotsnum;
			$s .= '] ';
			$this->_out($s);
		}

		$this->_out('/Contents '.($this->n+1).' 0 R>>');
		$this->_out('endobj');

		//Page content
		$this->_newobj();
		$p=($this->compress) ? gzcompress($this->pages[$n]) : $this->pages[$n];
		$this->_out('<<'.$filter.'/Length '.strlen($p).'>>');
		$this->_putstream($p);
		$this->_out('endobj');
	}
	$this->_putannots($n);


	//Pages root
	$this->offsets[1]=strlen($this->buffer);
	$this->_out('1 0 obj');
	$this->_out('<</Type /Pages');
	$kids='/Kids [';
	for($i=0;$i<$nb;$i++)
		$kids.=(3+2*$i).' 0 R ';
	$this->_out($kids.']');
	$this->_out('/Count '.$nb);
	$this->_out(sprintf('/MediaBox [0 0 %.3f %.3f]',$defwPt,$defhPt));
	$this->_out('>>');
	$this->_out('endobj');
}


function _putannots($n) {
	$nb=$this->page;
	for($n=1;$n<=$nb;$n++)
	{
		$annotobjs = array();
		if(isset($this->PageLinks[$n]) || isset($this->PageAnnots[$n])) {
			$wPt=$this->pageDim[$n]['w']*$this->k;
			$hPt=$this->pageDim[$n]['h']*$this->k;

			//Links
			if(isset($this->PageLinks[$n])) {
			   foreach($this->PageLinks[$n] as $key => $pl) {
				$this->_newobj();
				$annot='';
				$rect=sprintf('%.3f %.3f %.3f %.3f',$pl[0],$pl[1],$pl[0]+$pl[2],$pl[1]-$pl[3]);
				$annot .= '<</Type /Annot /Subtype /Link /Rect ['.$rect.']';
				$annot .= ' /Contents '.$this->_UTF16BEtextstring($pl[4]);
				$annot .= ' /NM ('.sprintf('%04u-%04u', $n, $key).')';
				$annot .= ' /M '.$this->_textstring('D:'.date('YmdHis'));
				$annot .= ' /Border [0 0 0]';
				if ($this->PDFA) { $annot .= ' /F 28'; }
				if (strpos($pl[4],'@')===0) {
					$p=substr($pl[4],1);
					//	$h=isset($this->OrientationChanges[$p]) ? $wPt : $hPt;
					$htarg=$this->pageDim[$p]['h']*$this->k;
					$annot.=sprintf(' /Dest [%d 0 R /XYZ 0 %.3f null]>>',1+2*$p,$htarg);
				}
				else if(is_string($pl[4])) {
					$annot .= ' /A <</S /URI /URI '.$this->_textstring($pl[4]).'>> >>';
				}
				else {
					$l=$this->links[$pl[4]];
					// may not be set if #link points to non-existent target
					if (isset($this->pageDim[$l[0]]['h'])) { $htarg=$this->pageDim[$l[0]]['h']*$this->k; }
					else { $htarg=$this->h*$this->k; } // doesn't really matter
					$annot.=sprintf(' /Dest [%d 0 R /XYZ 0 %.3f null]>>',1+2*$l[0],$htarg-$l[1]*$this->k);
				}
				$this->_out($annot);
				$this->_out('endobj');
			   }
			}


		}
	}
}





function _putfonts() {
	$nf=$this->n;
	$mqr=$this->_getMQR();	// mPDF 5.0
	if ($mqr) { set_magic_quotes_runtime(0); }
	foreach($this->FontFiles as $fontkey=>$info) {
	   // TrueType embedded
	   if (isset($info['type']) && $info['type']=='TTF' && !$info['sip'] && !$info['smp']) {	// mPDF 5.0.03 Added SMP
		$used = true;
		$asSubset = false;
		foreach($this->fonts AS $k=>$f) {
			if ($f['fontkey'] == $fontkey && $f['type']=='TTF') { 
				$used = $f['used']; 
				if ($used) {
					$nChars = (ord($f['cw'][0]) << 8) + ord($f['cw'][1]);	// mPDF 5.0
					$usage = intval(count($f['subset'])*100 / $nChars);
					$fsize = $info['length1'];
					// Always subset the very large TTF files
					if ($fsize > ($this->maxTTFFilesize *1024)) { $asSubset = true; }
					else if ($usage < $this->percentSubset) { $asSubset = true; }
				}
				$this->fonts[$k]['asSubset'] = $asSubset;
			}
		}
		if ($used && !$asSubset) {
			//Font file embedding
			$this->_newobj();
			$this->FontFiles[$fontkey]['n']=$this->n;

			$font='';
			// First see if there is a cached compressed file
			if (file_exists(_MPDF_TTFONTDATAPATH.$fontkey.'.z')) {
				$f=fopen(_MPDF_TTFONTDATAPATH.$fontkey.'.z','rb');
				if(!$f) { $this->Error('Font file not found'); }
				while(!feof($f)) { $font .= fread($f, 2048); }
				fclose($f);
			}
			else {
				$f=fopen($this->FontFiles[$fontkey]['ttffile'],'rb');
				if(!$f) { $this->Error('Font file not found'); }
				while(!feof($f)) { $font .= fread($f, 2048); }
				fclose($f);
				$font = gzcompress($font);
				if (is_writable(dirname(_MPDF_TTFONTDATAPATH.'x'))) {
					$fh = fopen(_MPDF_TTFONTDATAPATH.$fontkey.'.z',"wb");
					fwrite($fh,$font,strlen($font));
					fclose($fh);
				}
			}
			$this->_out('<</Length '.strlen($font));
			$this->_out('/Filter /FlateDecode');
			$this->_out('/Length1 '.$info['length1']);
			$this->_out('>>');
			$this->_putstream($font);
			$this->_out('endobj');
		}
	   }
	}

	$nfonts = count($this->fonts);
	$fctr = 1;
	foreach($this->fonts as $k=>$font) {
		//Font objects
		$type=$font['type'];
		$name=$font['name'];
		if ((!isset($font['used']) || !$font['used']) && $type=='TTF') { continue; }
		if ($this->progressBar) { $this->UpdateProgressBar(2,intval($fctr*100/$nfonts),'Writing Fonts'); $fctr++; }
		if (isset($font['asSubset'])) { $asSubset = $font['asSubset']; }
		else { $asSubset = ''; }
		if($type=='Type0') { 	// = Adobe CJK Fonts
			$this->fonts[$k]['n']=$this->n+1;
			$this->_newobj();
			$this->_out('<</Type /Font');
			$this->_putType0($font);
		}
		else if($type=='core') {
			//Standard font
			$this->fonts[$k]['n']=$this->n+1;
			if ($this->PDFA) { $this->Error('Core fonts are not allowed in PDF/A1-b files (Times, Helvetica, Courier etc.)'); }
			$this->_newobj();
			$this->_out('<</Type /Font');
			$this->_out('/BaseFont /'.$name);
			$this->_out('/Subtype /Type1');
			if($name!='Symbol' && $name!='ZapfDingbats') {
				$this->_out('/Encoding /WinAnsiEncoding');
			}
			$this->_out('>>');
			$this->_out('endobj');
		} 
		// TrueType embedded SUBSETS for SIP (CJK extB containing Supplementary Ideographic Plane 2)
		// Or Unicode Plane 1 - Supplementary Multilingual Plane
		else if ($type=='TTF' && ($font['sip'] || $font['smp'])) {	// mPDF 5.0.03
		   if (!$font['used']) { continue; }
		   $ssfaid="AA";
		   if (!class_exists('TTFontFile', false)) { include(_MPDF_PATH .'classes/ttfontsuni.php'); }
		   $ttf = new TTFontFile();
		   for($sfid=0;$sfid<count($font['subsetfontids']);$sfid++) {
			$this->fonts[$k]['n'][$sfid]=$this->n+1;		// NB an array for subset
			$subsetname = 'MPDF'.$ssfaid.'+'.$font['name'];
			$ssfaid++;
			$subset = $font['subsets'][$sfid];
			unset($subset[0]);
			$ttfontstream = $ttf->makeSubsetSIP($font['ttffile'], $subset, $font['TTCfontID'], $this->debugfonts);
			$ttfontsize = strlen($ttfontstream);
			$fontstream = gzcompress($ttfontstream);
			$widthstring = '';
			$toUnistring = '';
			foreach($font['subsets'][$sfid] AS $cp=>$u) {
				$w = $this->_getCharWidth($font['cw'], $u); 
				if ($w !== false) {
					$widthstring .= $w.' ';
				}
				else {
					$widthstring .= round($ttf->defaultWidth).' ';
				}
				if ($u > 65535) {
					$utf8 = chr(($u>>18)+240).chr((($u>>12)&63)+128).chr((($u>>6)&63)+128) .chr(($u&63)+128);
					$utf16 = mb_convert_encoding($utf8, 'UTF-16BE', 'UTF-8');
					$l1 = ord($utf16[0]);
					$h1 = ord($utf16[1]);
					$l2 = ord($utf16[2]);
					$h2 = ord($utf16[3]);
					$toUnistring .= sprintf("<%02s> <%02s%02s%02s%02s>\n", strtoupper(dechex($cp)), strtoupper(dechex($l1)), strtoupper(dechex($h1)), strtoupper(dechex($l2)), strtoupper(dechex($h2)));
				}
				else {
					$toUnistring .= sprintf("<%02s> <%04s>\n", strtoupper(dechex($cp)), strtoupper(dechex($u)));
				}
			}

			//Additional Type1 or TrueType font
			$this->_newobj();
			$this->_out('<</Type /Font');
			$this->_out('/BaseFont /'.$subsetname);
			$this->_out('/Subtype /TrueType');
			$this->_out('/FirstChar 0 /LastChar '.(count($font['subsets'][$sfid])));
			$this->_out('/Widths '.($this->n+1).' 0 R');
			$this->_out('/FontDescriptor '.($this->n+2).' 0 R');
			$this->_out('/ToUnicode '.($this->n + 3).' 0 R');
			$this->_out('>>');
			$this->_out('endobj');

			//Widths
			$this->_newobj();
			$this->_out('['.$widthstring.']');
			$this->_out('endobj');

			//Descriptor
			$this->_newobj();
			$s='<</Type /FontDescriptor /FontName /'.$subsetname."\n";
			foreach($font['desc'] as $kd=>$v) {
				if ($kd == 'Flags') { $v = $v | 4; $v = $v & ~32; }	// SYMBOLIC font flag
				$s.=' /'.$kd.' '.$v."\n";
			}
			$s.='/FontFile2 '.($this->n + 2).' 0 R';
			$this->_out($s.'>>');
			$this->_out('endobj');

			// ToUnicode
			$toUni = "stream\n";
			$toUni .= "/CIDInit /ProcSet findresource begin\n";
			$toUni .= "12 dict begin\n";
			$toUni .= "begincmap\n";
			$toUni .= "/CIDSystemInfo\n";
			$toUni .= "<</Registry (Adobe)\n";
			$toUni .= "/Ordering (UCS)\n";
			$toUni .= "/Supplement 0\n";
			$toUni .= ">> def\n";
			$toUni .= "/CMapName /Adobe-Identity-UCS def\n";
			$toUni .= "/CMapType 2 def\n";
			$toUni .= "1 begincodespacerange\n";
			$toUni .= "<00> <FF>\n";
			$toUni .= "endcodespacerange\n";
			$toUni .= count($font['subsets'][$sfid])." beginbfchar\n";
			$toUni .= $toUnistring;
			$toUni .= "endbfchar\n";
			$toUni .= "endcmap\n";
			$toUni .= "CMapName currentdict /CMap defineresource pop\n";
			$toUni .= "end\n";
			$toUni .= "end\n";
			$toUni .= "endstream\n";
			$toUni .= "endobj";
			$this->_newobj();
			$this->_out('<</Length '.(strlen($toUni)-24).'>>');
			$this->_out($toUni);

			//Font file 
			$this->_newobj();
			$this->_out('<</Length '.strlen($fontstream));
			$this->_out('/Filter /FlateDecode');
			$this->_out('/Length1 '.$ttfontsize);
			$this->_out('>>');
			$this->_putstream($fontstream);
			$this->_out('endobj');
		   }	// foreach subset
		   unset($ttf);
		} 
		// TrueType embedded SUBSETS or FULL
		else if ($type=='TTF') {
			$this->fonts[$k]['n']=$this->n+1;
			if ($asSubset ) {
				$ssfaid="A";
				if (!class_exists('TTFontFile', false)) { include(_MPDF_PATH .'classes/ttfontsuni.php'); }
				$ttf = new TTFontFile();
				$fontname = 'MPDFA'.$ssfaid.'+'.$font['name'];
				$subset = $font['subset'];
				unset($subset[0]);
				$ttfontstream = $ttf->makeSubset($font['ttffile'], $subset, $font['TTCfontID'], $this->debugfonts);
				$ttfontsize = strlen($ttfontstream);
				$fontstream = gzcompress($ttfontstream);
				$codeToGlyph = $ttf->codeToGlyph;
				unset($codeToGlyph[0]);
			}
			else { $fontname = $font['name']; }

			// Type0 Font
			// A composite font - a font composed of other fonts, organized hierarchically
			$this->_newobj();
			$this->_out('<</Type /Font');
			$this->_out('/Subtype /Type0');
			$this->_out('/BaseFont /'.$fontname.'');
			$this->_out('/Encoding /Identity-H'); 
			$this->_out('/DescendantFonts ['.($this->n + 1).' 0 R]');
			$this->_out('/ToUnicode '.($this->n + 2).' 0 R');
			$this->_out('>>');
			$this->_out('endobj');

			// CIDFontType2
			// A CIDFont whose glyph descriptions are based on TrueType font technology
			$this->_newobj();
			$this->_out('<</Type /Font');
			$this->_out('/Subtype /CIDFontType2');
			$this->_out('/BaseFont /'.$fontname.'');
			$this->_out('/CIDSystemInfo '.($this->n + 2).' 0 R'); 
			$this->_out('/FontDescriptor '.($this->n + 3).' 0 R');
			if (isset($font['desc']['MissingWidth'])){
				$this->_out('/DW '.$font['desc']['MissingWidth'].''); 
			}

			if (!$asSubset && file_exists(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cw')) {
					$w = '';
					$w=file_get_contents(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cw');
					$this->_out($w);
			}
			else {
				$this->_putTTfontwidths($font, $asSubset, $ttf->maxUni);
			}

			$this->_out('/CIDToGIDMap '.($this->n + 4).' 0 R');
			$this->_out('>>');
			$this->_out('endobj');

			// ToUnicode
			$this->_newobj();
			$this->_out('<</Length 345>>');
			$this->_out('stream');
			$this->_out('/CIDInit /ProcSet findresource begin');
			$this->_out('12 dict begin');
			$this->_out('begincmap');
			$this->_out('/CIDSystemInfo');
			$this->_out('<</Registry (Adobe)');
			$this->_out('/Ordering (UCS)');
			$this->_out('/Supplement 0');
			$this->_out('>> def');
			$this->_out('/CMapName /Adobe-Identity-UCS def');
			$this->_out('/CMapType 2 def');
			$this->_out('1 begincodespacerange');
			$this->_out('<0000> <FFFF>');
			$this->_out('endcodespacerange');
			$this->_out('1 beginbfrange');
			$this->_out('<0000> <FFFF> <0000>');
			$this->_out('endbfrange');
			$this->_out('endcmap');
			$this->_out('CMapName currentdict /CMap defineresource pop');
			$this->_out('end');
			$this->_out('end');
			$this->_out('endstream');
			$this->_out('endobj');

			// CIDSystemInfo dictionary
			$this->_newobj();
			$this->_out('<</Registry (Adobe)'); 
			$this->_out('/Ordering (UCS)');
			$this->_out('/Supplement 0');
			$this->_out('>>');
			$this->_out('endobj');

			// Font descriptor
			$this->_newobj();
			$this->_out('<</Type /FontDescriptor');
			$this->_out('/FontName /'.$fontname);
			foreach($font['desc'] as $kd=>$v) {
				if ($asSubset && $kd == 'Flags') { $v = $v | 4; $v = $v & ~32; }	// SYMBOLIC font flag
				$this->_out(' /'.$kd.' '.$v);
			}
			// mPDF 5.0
			if ($font['panose']) {
				$this->_out(' /Style << /Panose <'.$font['panose'].'> >>');
			}
			if ($asSubset ) {
				$this->_out('/FontFile2 '.($this->n + 2).' 0 R');
			}
			else if ($font['fontkey']) {
				// obj ID of a stream containing a TrueType font program
				$this->_out('/FontFile2 '.$this->FontFiles[$font['fontkey']]['n'].' 0 R');
			}
			$this->_out('>>');
			$this->_out('endobj');


			// Embed CIDToGIDMap
			// A specification of the mapping from CIDs to glyph indices
			if ($asSubset ) {
				$cidtogidmap = '';
				$cidtogidmap = str_pad('', 256*256*2, "\x00");
				foreach($codeToGlyph as $cc=>$glyph) {
					$cidtogidmap[$cc*2] = chr($glyph >> 8);
					$cidtogidmap[$cc*2 + 1] = chr($glyph & 0xFF);
				}
				$cidtogidmap = gzcompress($cidtogidmap);
			}
			else {
				// First see if there is a cached CIDToGIDMapfile
				$cidtogidmap = '';
				if (file_exists(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cgm')) {
					$f=fopen(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cgm','rb');
					while(!feof($f)) { $cidtogidmap .= fread($f, 2048); }
					fclose($f);
				}
				else {
					if (!class_exists('TTFontFile', false)) { include(_MPDF_PATH .'classes/ttfontsuni.php'); }
					$ttf = new TTFontFile();
					$charToGlyph = $ttf->getCTG($font['ttffile'], $font['TTCfontID'], $this->debugfonts);
					$cidtogidmap = str_pad('', 256*256*2, "\x00");
					foreach($charToGlyph as $cc=>$glyph) {
						$cidtogidmap[$cc*2] = chr($glyph >> 8);
						$cidtogidmap[$cc*2 + 1] = chr($glyph & 0xFF);
					}
					unset($ttf);
					$cidtogidmap = gzcompress($cidtogidmap);
					if (is_writable(dirname(_MPDF_TTFONTDATAPATH.'x'))) {
						$fh = fopen(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cgm',"wb");
						fwrite($fh,$cidtogidmap,strlen($cidtogidmap));
						fclose($fh);
					}
				}
			}
			$this->_newobj();
			$this->_out('<</Length '.strlen($cidtogidmap).'');
			$this->_out('/Filter /FlateDecode');
			$this->_out('>>');
			$this->_putstream($cidtogidmap);
			$this->_out('endobj');

			//Font file 
			if ($asSubset ) {
				$this->_newobj();
				$this->_out('<</Length '.strlen($fontstream));
				$this->_out('/Filter /FlateDecode');
				$this->_out('/Length1 '.$ttfontsize);
				$this->_out('>>');
				$this->_putstream($fontstream);
				$this->_out('endobj');
				unset($ttf);
			}
		} 
		else { $this->Error('Unsupported font type: '.$type.' ('.$name.')'); }
	}
	if ($mqr) { set_magic_quotes_runtime($mqr); }
}



function _putTTfontwidths(&$font, $asSubset, $maxUni) {
	if ($asSubset && file_exists(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cw127.php')) {
		include(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cw127.php') ;
		$startcid = 128;
	}
	else {
		$rangeid = 0;
		$range = array();
		$prevcid = -2;
		$prevwidth = -1;
		$interval = false;
		$startcid = 1;
	}
	if ($asSubset) { $cwlen = $maxUni + 1; }
	else { $cwlen = (strlen($font['cw'])/2); }

	// for each character
	for ($cid=$startcid; $cid<$cwlen; $cid++) {
		if ($cid==128 && $asSubset && (!file_exists(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cw127.php'))) {
			if (is_writable(dirname(_MPDF_TTFONTDATAPATH.'x'))) {
				$fh = fopen(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cw127.php',"wb");
				$cw127='<?php'."\n";
				$cw127.='$rangeid='.$rangeid.";\n";
				$cw127.='$prevcid='.$prevcid.";\n";
				$cw127.='$prevwidth='.$prevwidth.";\n";
				if ($interval) { $cw127.='$interval=true'.";\n"; }
				else { $cw127.='$interval=false'.";\n"; }
				$cw127.='$range='.var_export($range,true).";\n";
				$cw127.="?>";
				fwrite($fh,$cw127,strlen($cw127));
				fclose($fh);
			}
		}
		if ($font['cw'][$cid*2] == "\00" && $font['cw'][$cid*2+1] == "\00") { continue; }
		$width = (ord($font['cw'][$cid*2]) << 8) + ord($font['cw'][$cid*2+1]);
		if ($width == 65535) { $width = 0; }
		if ($asSubset && $cid > 255 && (!isset($font['subset'][$cid]) || !$font['subset'][$cid])) {
			continue;
		}
		if (!isset($font['dw']) || (isset($font['dw']) && $width != $font['dw'])) {
			if ($cid == ($prevcid + 1)) {
				// consecutive CID
				if ($width == $prevwidth) {
					if ($width == $range[$rangeid][0]) {
						$range[$rangeid][] = $width;
					} else {
						array_pop($range[$rangeid]);
						// new range
						$rangeid = $prevcid;
						$range[$rangeid] = array();
						$range[$rangeid][] = $prevwidth;
						$range[$rangeid][] = $width;
					}
					$interval = true;
					$range[$rangeid]['interval'] = true;
				} else {
					if ($interval) {
						// new range
						$rangeid = $cid;
						$range[$rangeid] = array();
						$range[$rangeid][] = $width;
					} else {
						$range[$rangeid][] = $width;
					}
					$interval = false;
				}
			} else {
				// new range
				$rangeid = $cid;
				$range[$rangeid] = array();
				$range[$rangeid][] = $width;
				$interval = false;
			}
			$prevcid = $cid;
			$prevwidth = $width;
		}
	}
	$w = $this->_putfontranges($range);
	$this->_out($w);
	if (!$asSubset) {
		if (is_writable(dirname(_MPDF_TTFONTDATAPATH.'x'))) {
			$fh = fopen(_MPDF_TTFONTDATAPATH.$font['fontkey'].'.cw',"wb");
			fwrite($fh,$w,strlen($w));
			fclose($fh);
		}
	}
}

function _putfontranges(&$range) {
	// optimize ranges
	$prevk = -1;
	$nextk = -1;
	$prevint = false;
	foreach ($range as $k => $ws) {
		$cws = count($ws);
		if (($k == $nextk) AND (!$prevint) AND ((!isset($ws['interval'])) OR ($cws < 4))) {
			if (isset($range[$k]['interval'])) {
				unset($range[$k]['interval']);
			}
			$range[$prevk] = array_merge($range[$prevk], $range[$k]);
			unset($range[$k]);
		} else {
			$prevk = $k;
		}
		$nextk = $k + $cws;
		if (isset($ws['interval'])) {
			if ($cws > 3) {
				$prevint = true;
			} else {
				$prevint = false;
			}
			unset($range[$k]['interval']);
			--$nextk;
		} else {
			$prevint = false;
		}
	}
	// output data
	$w = '';
	foreach ($range as $k => $ws) {
		if (count(array_count_values($ws)) == 1) {
			// interval mode is more compact
			$w .= ' '.$k.' '.($k + count($ws) - 1).' '.$ws[0];
		} else {
			// range mode
			$w .= ' '.$k.' [ '.implode(' ', $ws).' ]' . "\n";
		}
	}
	return '/W ['.$w.' ]';
}


function _putfontwidths(&$font, $cidoffset=0) {
	ksort($font['cw']);
	unset($font['cw'][65535]);
	$rangeid = 0;
	$range = array();
	$prevcid = -2;
	$prevwidth = -1;
	$interval = false;
	// for each character
	foreach ($font['cw'] as $cid => $width) {
		$cid -= $cidoffset;
		if (!isset($font['dw']) || (isset($font['dw']) && $width != $font['dw'])) {
			if ($cid == ($prevcid + 1)) {
				// consecutive CID
				if ($width == $prevwidth) {
					if ($width == $range[$rangeid][0]) {
						$range[$rangeid][] = $width;
					} else {
						array_pop($range[$rangeid]);
						// new range
						$rangeid = $prevcid;
						$range[$rangeid] = array();
						$range[$rangeid][] = $prevwidth;
						$range[$rangeid][] = $width;
					}
					$interval = true;
					$range[$rangeid]['interval'] = true;
				} else {
					if ($interval) {
						// new range
						$rangeid = $cid;
						$range[$rangeid] = array();
						$range[$rangeid][] = $width;
					} else {
						$range[$rangeid][] = $width;
					}
					$interval = false;
				}
			} else {
				// new range
				$rangeid = $cid;
				$range[$rangeid] = array();
				$range[$rangeid][] = $width;
				$interval = false;
			}
			$prevcid = $cid;
			$prevwidth = $width;
		}
	}
	$this->_out($this->_putfontranges($range));
}



// from class PDF_Chinese CJK EXTENSIONS
function _putType0(&$font)
{
	//Type0
	$this->_out('/Subtype /Type0');
	$this->_out('/BaseFont /'.$font['name'].'-'.$font['CMap']);
	$this->_out('/Encoding /'.$font['CMap']);
	$this->_out('/DescendantFonts ['.($this->n+1).' 0 R]');
	$this->_out('>>');
	$this->_out('endobj');
	//CIDFont
	$this->_newobj();
	$this->_out('<</Type /Font');
	$this->_out('/Subtype /CIDFontType0');
	$this->_out('/BaseFont /'.$font['name']);

	$cidinfo = '/Registry '.$this->_textstring('Adobe');
	$cidinfo .= ' /Ordering '.$this->_textstring($font['registry']['ordering']);
	$cidinfo .= ' /Supplement '.$font['registry']['supplement'];
	$this->_out('/CIDSystemInfo <<'.$cidinfo.'>>');

	$this->_out('/FontDescriptor '.($this->n+1).' 0 R');
	if (isset($font['MissingWidth'])){
		$this->_out('/DW '.$font['MissingWidth'].''); 
	}
	$this->_putfontwidths($font, 31);	// mPDF 5.0
	$this->_out('>>');
	$this->_out('endobj');

	//Font descriptor
	$this->_newobj();
	$s = '<</Type /FontDescriptor /FontName /'.$font['name'];
	foreach ($font['desc'] as $k => $v) {
		if ($k != 'Style') {
			$s .= ' /'.$k.' '.$v.'';
		}
	}
	$this->_out($s.'>>');
	$this->_out('endobj');
}



function _putimages()
{
	$filter=($this->compress) ? '/Filter /FlateDecode ' : '';
	reset($this->images);
	while(list($file,$info)=each($this->images))
	{
		$this->_newobj();
		$this->images[$file]['n']=$this->n;
		$this->_out('<</Type /XObject');
		$this->_out('/Subtype /Image');
		$this->_out('/Width '.$info['w']);
		$this->_out('/Height '.$info['h']);

		if (isset($info['masked'])) {
			$this->_out('/SMask '.($this->n - 1).' 0 R');
		}

		if($info['cs']=='Indexed')
			$this->_out('/ColorSpace [/Indexed /DeviceRGB '.(strlen($info['pal'])/3-1).' '.($this->n+1).' 0 R]');
		else
		{
			$this->_out('/ColorSpace /'.$info['cs']);
			if($info['cs']=='DeviceCMYK') {
				if ($this->PDFA) { $this->Error("PDFA1-b does not permit Images using DeviceCMYK colour space (".$file.")."); }
				$this->_out('/Decode [1 0 1 0 1 0 1 0]');
			}
		}
		$this->_out('/BitsPerComponent '.$info['bpc']);
		if (isset($info['f']) && $info['f']) { $this->_out('/Filter /'.$info['f']); }
		if(isset($info['parms'])) { $this->_out($info['parms']); }
		if(isset($info['trns']) and is_array($info['trns']))
		{
			$trns='';
			for($i=0;$i<count($info['trns']);$i++)
				$trns.=$info['trns'][$i].' '.$info['trns'][$i].' ';
			$this->_out('/Mask ['.$trns.']');
		}
		$this->_out('/Length '.strlen($info['data']).'>>');
		$this->_putstream($info['data']);
		unset($this->images[$file]['data']);
		$this->_out('endobj');
		//Palette
		if($info['cs']=='Indexed')
		{
			$this->_newobj();
			$pal=($this->compress) ? gzcompress($info['pal']) : $info['pal'];
			$this->_out('<<'.$filter.'/Length '.strlen($pal).'>>');
			$this->_putstream($pal);
			$this->_out('endobj');
		}
	}
}

function _putinfo()
{
	$this->_out('/Producer '.$this->_UTF16BEtextstring('mPDF '.mPDF_VERSION));
	if(!empty($this->title))
		$this->_out('/Title '.$this->_UTF16BEtextstring($this->title));
	if(!empty($this->subject))
		$this->_out('/Subject '.$this->_UTF16BEtextstring($this->subject));
	if(!empty($this->author))
		$this->_out('/Author '.$this->_UTF16BEtextstring($this->author));
	if(!empty($this->keywords))
		$this->_out('/Keywords '.$this->_UTF16BEtextstring($this->keywords));
	if(!empty($this->creator))
		$this->_out('/Creator '.$this->_UTF16BEtextstring($this->creator));

	$z = date('O'); // +0200
	$offset = substr($z,0,3)."'".substr($z,3,2)."'";
	$this->_out('/CreationDate '.$this->_textstring(date('YmdHis').$offset));
	$this->_out('/ModDate '.$this->_textstring(date('YmdHis').$offset));
}

function _putmetadata() {
	$this->_newobj();
	$this->MetadataRoot = $this->n;
	$Producer = 'mPDF '.mPDF_VERSION;
	$z = date('O'); // +0200
	$offset = substr($z,0,3).':'.substr($z,3,2);
	$CreationDate = date('Y-m-d\TH:i:s').$offset;	// 2006-03-10T10:47:26-05:00 2006-06-19T09:05:17Z
	$uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)  );


	$m = '<?xpacket begin="'.chr(239).chr(187).chr(191).'" id="W5M0MpCehiHzreSzNTczkc9d"?>'."\n";	// begin = FEFF BOM
	$m .= ' <x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="3.1-701">'."\n";
	$m .= '  <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">'."\n";
	$m .= '   <rdf:Description rdf:about="" xmlns:pdf="http://ns.adobe.com/pdf/1.3/">'."\n";
	$m .= '    <pdf:Producer>'.$Producer.'</pdf:Producer>'."\n";
	if(!empty($this->keywords)) {
		$m .= '    <pdf:Keywords>'.$this->keywords.'</pdf:Keywords>'."\n";
	}
	$m .= '   </rdf:Description>'."\n";
	$m .= '   <rdf:Description rdf:about="" xmlns:xmp="http://ns.adobe.com/xap/1.0/">'."\n";
	$m .= '    <xmp:CreateDate>'.$CreationDate.'</xmp:CreateDate>'."\n";
	$m .= '    <xmp:ModifyDate>'.$CreationDate.'</xmp:ModifyDate>'."\n";
	$m .= '    <xmp:MetadataDate>'.$CreationDate.'</xmp:MetadataDate>'."\n";

	if(!empty($this->creator)) {
		$m .= '    <xmp:CreatorTool>'.$this->creator.'</xmp:CreatorTool>'."\n";
	}


	$m .= '   </rdf:Description>'."\n";
	$m .= '   <rdf:Description rdf:about="" xmlns:dc="http://purl.org/dc/elements/1.1/">'."\n";
	$m .= '    <dc:format>application/pdf</dc:format>'."\n";
	if(!empty($this->title)) {
		$m .= '    <dc:title>
     <rdf:Alt>
      <rdf:li xml:lang="x-default">'.$this->title.'</rdf:li>
     </rdf:Alt>
    </dc:title>'."\n";
	}
	if(!empty($this->keywords)) {
		$m .= '    <dc:subject>
     <rdf:Bag>
      <rdf:li>'.$this->keywords.'</rdf:li>
     </rdf:Bag>
    </dc:subject>'."\n";
	}
	if(!empty($this->subject)) {
		$m .= '    <dc:description>
     <rdf:Alt>
      <rdf:li xml:lang="x-default">'.$this->subject.'</rdf:li>
     </rdf:Alt>
    </dc:description>'."\n";
	}
	if(!empty($this->author)) {
		$m .= '    <dc:creator>
     <rdf:Seq>
      <rdf:li>'.$this->author.'</rdf:li>
     </rdf:Seq>
    </dc:creator>'."\n";
	}
	$m .= '   </rdf:Description>'."\n";

// This bit is specific to PDFA-1b
	$m .= '   <rdf:Description rdf:about="" xmlns:pdfaid="http://www.aiim.org/pdfa/ns/id/" >'."\n";
	$m .= '    <pdfaid:part>1</pdfaid:part>'."\n";
	$m .= '    <pdfaid:conformance>B</pdfaid:conformance>'."\n";
	$m .= '    <pdfaid:amd>2005</pdfaid:amd>'."\n";
	$m .= '   </rdf:Description>'."\n";

	$m .= '   <rdf:Description rdf:about="" xmlns:xmpMM="http://ns.adobe.com/xap/1.0/mm/">'."\n";
	$m .= '    <xmpMM:DocumentID>uuid:'.$uuid.'</xmpMM:DocumentID>'."\n";
	$m .= '   </rdf:Description>'."\n";
	$m .= '  </rdf:RDF>'."\n";
	$m .= ' </x:xmpmeta>'."\n";
	$m .= str_repeat(str_repeat(' ',100)."\n",20);	// 2-4kB whitespace padding required
	$m .= '<?xpacket end="w"?>';	// "r" read only
	$this->_out('<</Type/Metadata/Subtype/XML/Length '.strlen($m).'>>');
	$this->_putstream($m);
	$this->_out('endobj');
}

function _putoutputintent() {
	$this->_newobj();
	$this->OutputIntentRoot = $this->n;
	if ($this->compress) { $s = gzcompress($s); }
	$this->_out('<</Type /OutputIntent');
	if ($this->ICCProfile)
		$this->_out('/Info ('.$this->ICCProfile.')');
	else 
		$this->_out('/Info (sRGB)');
	$this->_out('/S /GTS_PDFA1');
	$this->_out('/OutputConditionIdentifier (Custom)');
	$this->_out('/OutputCondition ()');
	$this->_out('/DestOutputProfile '.($this->n+1).' 0 R >>');
	$this->_out('endobj');

	$this->_newobj();
	if ($this->ICCProfile)
		$s = file_get_contents(_MPDF_PATH.'iccprofiles/'.$this->ICCProfile.'.icc');
	else 
		$s = file_get_contents(_MPDF_PATH.'iccprofiles/sRGB_IEC61966-2-1.icc');
	if ($this->compress) { $s = gzcompress($s); }
	$this->_out('<</N 3');
	if ($this->compress)
		$this->_out('/Filter /FlateDecode ');
	$this->_out('/Length '.strlen($s).'>>');
	$this->_putstream($s);
	$this->_out('endobj');
}


function _putcatalog() {
	$this->_out('/Type /Catalog');
	$this->_out('/Pages 1 0 R');
	if($this->ZoomMode=='fullpage')	$this->_out('/OpenAction [3 0 R /Fit]');
	elseif($this->ZoomMode=='fullwidth') $this->_out('/OpenAction [3 0 R /FitH null]');
	elseif($this->ZoomMode=='real')	$this->_out('/OpenAction [3 0 R /XYZ null null 1]');
	elseif(!is_string($this->ZoomMode))	$this->_out('/OpenAction [3 0 R /XYZ null null '.($this->ZoomMode/100).']');
	else	$this->_out('/OpenAction [3 0 R /XYZ null null null]');
	if($this->LayoutMode=='single')	$this->_out('/PageLayout /SinglePage');
	elseif($this->LayoutMode=='continuous')	$this->_out('/PageLayout /OneColumn');
	elseif($this->LayoutMode=='two') {
	  if ($this->mirrorMargins) { $this->_out('/PageLayout /TwoColumnRight'); }
	  else { $this->_out('/PageLayout /TwoColumnLeft'); }
	}
	if(count($this->BMoutlines)>0) {
	      $this->_out('/Outlines '.$this->OutlineRoot.' 0 R');
	      $this->_out('/PageMode /UseOutlines');
	}
	if(is_int(strpos($this->DisplayPreferences,'FullScreen'))) $this->_out('/PageMode /FullScreen');

	// Metadata
	if ($this->PDFA) { 
		$this->_out('/Metadata '.$this->MetadataRoot.' 0 R');
	}
	// OutputIntents
	if ($this->PDFA || $this->ICCProfile) { 
		$this->_out('/OutputIntents ['.$this->OutputIntentRoot.' 0 R]');
	}

  if($this->DisplayPreferences || $this->directionality == 'rtl' || $this->mirrorMargins) {
	$this->_out('/ViewerPreferences<<');
	if(is_int(strpos($this->DisplayPreferences,'HideMenubar'))) $this->_out('/HideMenubar true');
	if(is_int(strpos($this->DisplayPreferences,'HideToolbar'))) $this->_out('/HideToolbar true');
	if(is_int(strpos($this->DisplayPreferences,'HideWindowUI'))) $this->_out('/HideWindowUI true');
	if(is_int(strpos($this->DisplayPreferences,'DisplayDocTitle'))) $this->_out('/DisplayDocTitle true');
	if(is_int(strpos($this->DisplayPreferences,'CenterWindow'))) $this->_out('/CenterWindow true');
	if(is_int(strpos($this->DisplayPreferences,'FitWindow'))) $this->_out('/FitWindow true');
	if($this->directionality == 'rtl') $this->_out('/Direction /R2L');

	if($this->mirrorMargins) {
		// if ($this->DefOrientation=='P') $this->_out('/Duplex /DuplexFlipShortEdge');
		$this->_out('/Duplex /DuplexFlipLongEdge');	// PDF v1.7+
	}
	$this->_out('>>');
  }
}

// Inactive function left for backwards compatability
function SetUserRights($enable=true, $annots="", $form="", $signature="") {
	// Does nothing
}

function _enddoc() {
	if ($this->progressBar) { $this->UpdateProgressBar(2,'10','Writing Headers & Footers'); }
	$this->_puthtmlheaders();	// *HTMLHEADERS-FOOTERS*
	if ($this->progressBar) { $this->UpdateProgressBar(2,'20','Writing Pages'); }
	// Remove references to unused fonts (usually default font)
	foreach($this->fonts as $fk=>$font) {
	   if (!$font['used'] && ($font['type']=='TTF')) { 
		if ($font['sip'] || $font['smp']) {	// mPDF 5.0.03 Added SMP
			foreach($font['subsetfontids'] AS $k => $fid) {
				foreach($this->pages AS $pn=>$page) { 
					$this->pages[$pn] = preg_replace('/\s\/F'.$fid.' \d[\d.]* Tf\s/is',' ',$this->pages[$pn]); 
				}
			}
		}
		else { 
				foreach($this->pages AS $pn=>$page) { 
					$this->pages[$pn] = preg_replace('/\s\/F'.$font['i'].' \d[\d.]* Tf\s/is',' ',$this->pages[$pn]); 
				}
		}
	   }
	}

	$this->_putpages();
	if ($this->progressBar) { $this->UpdateProgressBar(2,'30','Writing document resources'); }
	$this->_putresources();
	//Info
	$this->_newobj();
	$this->InfoRoot = $this->n;
	$this->_out('<<');
	if ($this->progressBar) { $this->UpdateProgressBar(2,'80','Writing document info'); }
	$this->_putinfo();
	$this->_out('>>');
	$this->_out('endobj');

	// METADATA
	if ($this->PDFA) { $this->_putmetadata(); }
	// OUTPUTINTENT
	if ($this->PDFA || $this->ICCProfile) { $this->_putoutputintent(); }

	//Catalog
	$this->_newobj();
	$this->_out('<<');
	if ($this->progressBar) { $this->UpdateProgressBar(2,'90','Writing document catalog'); }
	$this->_putcatalog();
	$this->_out('>>');
	$this->_out('endobj');
	//Cross-ref
	$o=strlen($this->buffer);
	$this->_out('xref');
	$this->_out('0 '.($this->n+1));
	$this->_out('0000000000 65535 f ');
	for($i=1; $i <= $this->n ; $i++)
		$this->_out(sprintf('%010d 00000 n ',$this->offsets[$i]));
	//Trailer
	$this->_out('trailer');
	$this->_out('<<');
	$this->_puttrailer();
	$this->_out('>>');
	$this->_out('startxref');
	$this->_out($o);

	$this->buffer .= '%%EOF';
	$this->state=3;
}

function _beginpage($orientation,$mgl='',$mgr='',$mgt='',$mgb='',$mgh='',$mgf='',$ohname='',$ehname='',$ofname='',$efname='',$ohvalue=0,$ehvalue=0,$ofvalue=0,$efvalue=0,$pagesel='',$newformat='') {
	$this->page++;
	$this->pages[$this->page]='';
	$this->state=2;
	$resetHTMLHeadersrequired = false;


	if ($newformat) { $this->_setPageSize($newformat, $orientation); }

	//Page orientation
	if(!$orientation)
		$orientation=$this->DefOrientation;
	else {
		$orientation=strtoupper(substr($orientation,0,1));
		if($orientation!=$this->DefOrientation)
			$this->OrientationChanges[$this->page]=true;
	}
	if($orientation!=$this->CurOrientation || $newformat) {

		//Change orientation
		if($orientation=='P') {
			$this->wPt=$this->fwPt;
			$this->hPt=$this->fhPt;
			$this->w=$this->fw;
			$this->h=$this->fh;
		   if (($this->forcePortraitHeaders || $this->forcePortraitMargins) && $this->DefOrientation=='P') {
			$this->tMargin = $this->orig_tMargin;
			$this->bMargin = $this->orig_bMargin;
			$this->DeflMargin = $this->orig_lMargin;
			$this->DefrMargin = $this->orig_rMargin;
			$this->margin_header = $this->orig_hMargin;
			$this->margin_footer = $this->orig_fMargin;
		   }
		   else { $resetHTMLHeadersrequired = true; }	// *HTMLHEADERS-FOOTERS*
		}
		else {
			$this->wPt=$this->fhPt;
			$this->hPt=$this->fwPt;
			$this->w=$this->fh;
			$this->h=$this->fw;
		   if (($this->forcePortraitHeaders || $this->forcePortraitMargins) && $this->DefOrientation=='P') {
			$this->tMargin = $this->orig_lMargin;
			$this->bMargin = $this->orig_rMargin;
			$this->DeflMargin = $this->orig_bMargin;
			$this->DefrMargin = $this->orig_tMargin;
			$this->margin_header = $this->orig_hMargin;
			$this->margin_footer = $this->orig_fMargin;
		   }
		   else { $resetHTMLHeadersrequired = true; }	// *HTMLHEADERS-FOOTERS*

		}
		$this->CurOrientation=$orientation;
		$this->ResetMargins();
		$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
		$this->PageBreakTrigger=$this->h-$this->bMargin;
	}

	$this->pageDim[$this->page]['w']=$this->w ;
	$this->pageDim[$this->page]['h']=$this->h ;
	// If Page Margins are re-defined
	// strlen()>0 is used to pick up (integer) 0, (string) '0', or set value
	if ((strlen($mgl)>0 && $this->DeflMargin != $mgl) || (strlen($mgr)>0 && $this->DefrMargin != $mgr) || (strlen($mgt)>0 && $this->tMargin != $mgt) || (strlen($mgb)>0 && $this->bMargin != $mgb) || (strlen($mgh)>0 && $this->margin_header!=$mgh) || (strlen($mgf)>0 && $this->margin_footer!=$mgf)) {
		if (strlen($mgl)>0)  $this->DeflMargin = $mgl;
		if (strlen($mgr)>0)  $this->DefrMargin = $mgr;
		if (strlen($mgt)>0)  $this->tMargin = $mgt;
		if (strlen($mgb)>0)  $this->bMargin = $mgb;
		if (strlen($mgh)>0)  $this->margin_header=$mgh;
		if (strlen($mgf)>0)  $this->margin_footer=$mgf;
		$this->ResetMargins();
		$this->SetAutoPageBreak($this->autoPageBreak,$this->bMargin);
		$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
		$resetHTMLHeadersrequired = true; 	// *HTMLHEADERS-FOOTERS*
	}

	$this->ResetMargins();
	$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
	$this->SetAutoPageBreak($this->autoPageBreak,$this->bMargin);

	// Reset column top margin
	$this->y0 = $this->tMargin;

	$this->x=$this->lMargin;
	$this->y=$this->tMargin;
	$this->FontFamily='';


	// HEADERS AND FOOTERS
	if ($ohvalue<0 || strtoupper($ohvalue)=='OFF') { 
		$this->HTMLHeader = ''; 
		$this->headerDetails['odd'] = array(); 
		$resetHTMLHeadersrequired = true;	// *HTMLHEADERS-FOOTERS*
	}
	else if ($ohname && $ohvalue>0) {
	   if (preg_match('/^html_(.*)$/i',$ohname,$n)) {
		if (isset($this->pageHTMLheaders[$n[1]])) { $this->HTMLHeader = $this->pageHTMLheaders[$n[1]]; }
		else { $this->HTMLHeader = ''; }
		$this->headerDetails['odd'] = array(); 
		$resetHTMLHeadersrequired = true;
	   }
	   else {
		if (isset($this->pageheaders[$ohname])) { $this->headerDetails['odd'] = $this->pageheaders[$ohname]; } 
		else { $this->headerDetails['odd'] = array(); }
		$this->HTMLHeader = ''; 
		$resetHTMLHeadersrequired = false;
	   }
	}

	if ($ehvalue<0 || strtoupper($ehvalue)=='OFF') { 
		$this->HTMLHeaderE = ''; 
		$this->headerDetails['even'] = array(); 
		$resetHTMLHeadersrequired = true;	// *HTMLHEADERS-FOOTERS*
	}
	else if ($ehname && $ehvalue>0) {
	   if (preg_match('/^html_(.*)$/i',$ehname,$n)) {
		if (isset($this->pageHTMLheaders[$n[1]])) { $this->HTMLHeaderE = $this->pageHTMLheaders[$n[1]]; } 
		else { $this->HTMLHeaderE = ''; }
		$this->headerDetails['even'] = array(); 
		$resetHTMLHeadersrequired = true;
	   }
	   else {
		if (isset($this->pageheaders[$ehname])) { $this->headerDetails['even'] = $this->pageheaders[$ehname]; }
		else { $this->headerDetails['even'] = array(); }
		$this->HTMLHeaderE = ''; 
		$resetHTMLHeadersrequired = false;
	   }
	}

	if ($ofvalue<0 || strtoupper($ofvalue)=='OFF') { 
		$this->HTMLFooter = ''; 
		$this->footerDetails['odd'] = array(); 
		$resetHTMLHeadersrequired = true;	// *HTMLHEADERS-FOOTERS*
	}
	else if ($ofname && $ofvalue>0) {
	   if (preg_match('/^html_(.*)$/i',$ofname,$n)) {
		if (isset($this->pageHTMLfooters[$n[1]])) { $this->HTMLFooter = $this->pageHTMLfooters[$n[1]]; }
		else { $this->HTMLFooter = ''; }
		$this->footerDetails['odd'] = array(); 
		$resetHTMLHeadersrequired = true;
	   }
	   else {
		if (isset($this->pagefooters[$ofname])) { $this->footerDetails['odd'] = $this->pagefooters[$ofname]; }
		else { $this->footerDetails['odd'] = array(); }
		$this->HTMLFooter = ''; 
		$resetHTMLHeadersrequired = true;
	   }
	}

	if ($efvalue<0 || strtoupper($efvalue)=='OFF') { 
		$this->HTMLFooterE = ''; 
		$this->footerDetails['even'] = array(); 
		$resetHTMLHeadersrequired = true;	// *HTMLHEADERS-FOOTERS*
	}
	else if ($efname && $efvalue>0) {
	   if (preg_match('/^html_(.*)$/i',$efname,$n)) {
		if (isset($this->pageHTMLfooters[$n[1]])) { $this->HTMLFooterE = $this->pageHTMLfooters[$n[1]]; } 
		else { $this->HTMLFooterE = ''; }
		$this->footerDetails['even'] = array(); 
		$resetHTMLHeadersrequired = true;
	   }
	   else {
		if (isset($this->pagefooters[$efname])) { $this->footerDetails['even'] = $this->pagefooters[$efname]; } 
		else { $this->footerDetails['even'] = array(); }
		$this->HTMLFooterE = ''; 
		$resetHTMLHeadersrequired = true;
	   }
	}

	if ($resetHTMLHeadersrequired) {
		$this->SetHTMLHeader($this->HTMLHeader );
		$this->SetHTMLHeader($this->HTMLHeaderE ,'E');
		$this->SetHTMLFooter($this->HTMLFooter );
		$this->SetHTMLFooter($this->HTMLFooterE ,'E');
	}


	if (($this->mirrorMargins) && (($this->page)%2==0)) {	// EVEN
		$this->_setAutoHeaderHeight($this->headerDetails['even'], $this->HTMLHeaderE);
		$this->_setAutoFooterHeight($this->footerDetails['even'], $this->HTMLFooterE);
	}
	else {	// ODD or DEFAULT
		$this->_setAutoHeaderHeight($this->headerDetails['odd'], $this->HTMLHeader);
		$this->_setAutoFooterHeight($this->footerDetails['odd'], $this->HTMLFooter);
	}
	// Reset column top margin
	$this->y0 = $this->tMargin;

	$this->x=$this->lMargin;
	$this->y=$this->tMargin;
}



function _setAutoHeaderHeight(&$det, &$htmlh) {
  if ($this->setAutoTopMargin=='pad') {
	if ($htmlh['h']) { $h = $htmlh['h']; }
	else if ($det) { $h = $this->_getHFHeight($det,'H'); }
	else { $h = 0; }
	$this->tMargin = $this->margin_header + $h + $this->orig_tMargin;
  }
  else if ($this->setAutoTopMargin=='stretch') {
	if ($htmlh['h']) { $h = $htmlh['h']; }
	else if ($det) { $h = $this->_getHFHeight($det,'H'); }
	else { $h = 0; }
	$this->tMargin = max($this->orig_tMargin, $this->margin_header + $h + $this->autoMarginPadding);
  }
}


function _setAutoFooterHeight(&$det, &$htmlf) {
  if ($this->setAutoBottomMargin=='pad') {
	if ($htmlf['h']) { $h = $htmlf['h']; }
	else if ($det) { $h = $this->_getHFHeight($det,'F'); }
	else { $h = 0; }
	$this->bMargin = $this->margin_footer + $h + $this->orig_bMargin;
	$this->PageBreakTrigger=$this->h-$this->bMargin ;
  }
  else if ($this->setAutoBottomMargin=='stretch') {
	if ($htmlf['h']) { $h = $htmlf['h']; }
	else if ($det) { $h = $this->_getHFHeight($det,'F'); }
	else { $h = 0; }
	$this->bMargin = max($this->orig_bMargin, $this->margin_footer + $h + $this->autoMarginPadding);
	$this->PageBreakTrigger=$this->h-$this->bMargin ;
  }
}

function _getHFHeight(&$det,$end) {
	$h = 0;
	if(count($det)) {
		foreach(array('L','C','R') AS $pos) {
		  if (isset($det[$pos]['content']) && $det[$pos]['content']) {
			if (isset($det[$pos]['font-size']) && $det[$pos]['font-size']) { $hfsz = $det[$pos]['font-size']; }
			else { $hfsz = $this->default_font_size; }
			$h = max($h,$hfsz/$this->k);
		  }
		}
		if ($det['line'] && $end=='H') { $h += $h/$this->k*$this->header_line_spacing; }
		else if ($det['line'] && $end=='F') { $h += $h/$this->k*$this->footer_line_spacing; }
   	}
	return $h;
}


function _endpage() {

	//End of page contents
	$this->state=1;
}

function _newobj($obj_id=false,$onlynewobj=false) {
		if (!$obj_id) {
			$obj_id = ++$this->n;
		}
		//Begin a new object
		if (!$onlynewobj) {
			$this->offsets[$obj_id] = strlen($this->buffer);
			$this->_out($obj_id.' 0 obj');
			$this->_current_obj_id = $obj_id; // for later use with encryption
		}
}

function _dounderline($x,$y,$txt) {
	// Now print line exactly where $y secifies - called from Text() and Cell() - adjust  position there
	// WORD SPACING
      $w =($this->GetStringWidth($txt)*$this->k) + ($this->charspacing * mb_strlen( $txt, $this->mb_enc )) 
		 + ( $this->ws * mb_substr_count( $txt, ' ', $this->mb_enc ));
	//Draw a line
	return sprintf('%.3f %.3f m %.3f %.3f l S',$x*$this->k,($this->h-$y)*$this->k,($x*$this->k)+$w,($this->h-$y)*$this->k);
}


function _imageError($file, $firsttime, $msg) {
	// Save re-trying image URL's which have already failed
	$this->failedimages[$file] = true;
	if ($firsttime && ($this->showImageErrors || $this->debug)) {
			$this->Error("IMAGE Error (".$file."): ".$msg);
	}
	return false;
}


function _getImage(&$file, $firsttime=true, $allowvector=true, $orig_srcpath=false) { 
	// firsttime i.e. whether to add to this->images - use false when calling iteratively
	// Image Data passed directly as var:varname
	if (preg_match('/var:\s*(.*)/',$file, $v)) { 
		$data = $this->$v[1];
		$file = md5($data);
	}

	if ($firsttime && preg_match('/(.*\/)([^\/]*)/',$file,$fm)) {
		if (strlen($fm[2])) { $file = $fm[1].preg_replace('/ /','%20',$fm[2]); }
	}
	if ($orig_srcpath && isset($this->images[$orig_srcpath])) { $file=$orig_srcpath; return $this->images[$orig_srcpath]; }
	if (isset($this->images[$file])) { return $this->images[$file]; }
	else if ($orig_srcpath && isset($this->formobjects[$orig_srcpath])) { $file=$orig_srcpath; return $this->formobjects[$file]; }
	else if (isset($this->formobjects[$file])) { return $this->formobjects[$file]; }
	// Save re-trying image URL's which have already failed
	else if ($firsttime && isset($this->failedimages[$file])) { return $this->_imageError($file, $firsttime, ''); } 
	if (!$data) {
		$type = '';
		$data = '';
		$mqr=$this->_getMQR();	// mPDF 5.0
		if ($mqr) { set_magic_quotes_runtime(0); }

 		if ($orig_srcpath && $this->basepathIsLocal && $check = @fopen($orig_srcpath,"rb")) {
			fclose($check); 
			$file=$orig_srcpath;
			$data = file_get_contents($file);
			$type = $this->_imageTypeFromString($data);
		}
		if (!$data && $check = @fopen($file,"rb")) { 
			fclose($check); 
			$data = file_get_contents($file);
			$type = $this->_imageTypeFromString($data);
		}
		if ((!$data || !$type) && !ini_get('allow_url_fopen')) {	// only worth trying if remote file and !ini_get('allow_url_fopen')
			$this->file_get_contents_by_socket($file, $data);	// needs full url?? even on local (never needed for local)
			if ($data) { $type = $this->_imageTypeFromString($data); }
		}
		if ((!$data || !$type) && !ini_get('allow_url_fopen') && function_exists("curl_init")) {
			$this->file_get_contents_by_curl($file, $data);		// needs full url?? even on local (never needed for local)
			if ($data) { $type = $this->_imageTypeFromString($data); }
		}

		if ($mqr) { set_magic_quotes_runtime($mqr); }
	}
	if (!$data) { return $this->_imageError($file, $firsttime, 'Could not find image file'); }
	if (!$type) { $type = $this->_imageTypeFromString($data); }
	if (($type == 'wmf' || $type == 'svg') && !$allowvector) { return $this->_imageError($file, $firsttime, 'WMF or SVG image file not supported in this context'); }

	// SVG
	if ($type == 'svg') {
		if (!class_exists('SVG', false)) { include(_MPDF_PATH .'classes/svg.php'); }
		$svg = new SVG($this);
		$family=$this->FontFamily;
		$style=$this->FontStyle;
		$size=$this->FontSizePt;
		$info = $svg->ImageSVG($data);
		//Restore font
		if($family) $this->SetFont($family,$style,$size,false);
		if (!$info) { return $this->_imageError($file, $firsttime, 'Error parsing SVG file'); }
		$info['type']='svg';
		$info['i']=count($this->formobjects)+1;
		$this->formobjects[$file]=$info;
		return $info;
	}

	// JPEG
	if ($type == 'jpeg' || $type == 'jpg') {
		$hdr = $this->_jpgHeaderFromString($data);
		if (!$hdr) { return $this->_imageError($file, $firsttime, 'Error parsing JPG header'); }
		$a = $this->_jpgDataFromHeader($hdr);
		if ($a[2] == 'DeviceCMYK' && $this->PDFA) { 
			if (!function_exists("gd_info")) { $this->Error("JPG image may not use CMYK color space (".$file.")."); }
			if (!$this->PDFAauto) { $this->PDFAwarnings[] = "JPG image may not use CMYK color space - ".$file." - (Image converted to RGB. NB This will alter the colour profile of the image.)"; }
			// convert to RGB image
			$im = @imagecreatefromstring($data);
			if ($im) {
				$tempfile = _MPDF_TEMP_PATH.'_tempImgPNG'.RAND(1,10000).'.png';
				imageinterlace($im, false);
				$check = @imagepng($im, $tempfile);
				if (!$check) { return $this->_imageError($file, $firsttime, 'Error creating temporary file ('.$tempfile.') whilst using GD library to parse JPG(CMYK) image'); }
				$info = $this->_getImage($tempfile, false);
				if (!$info) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file ('.$tempfile.') created with GD library to parse JPG(CMYK) image'); }
				imagedestroy($im);
				unlink($tempfile);
				$info['type']='jpg';
				if ($firsttime) {
					$info['i']=count($this->images)+1;
					$this->images[$file]=$info;
				}
				return $info;
			}
			else { return $this->_imageError($file, $firsttime, 'Error creating GD image file from JPG(CMYK) image'); }
		}
		$info = array('w'=>$a[0],'h'=>$a[1],'cs'=>$a[2],'bpc'=>$a[3],'f'=>'DCTDecode','data'=>$data);
		$info['type']='jpg';
		if ($firsttime) {
			$info['i']=count($this->images)+1;
			$this->images[$file]=$info;
		}
		return $info;
	}

	// PNG
	else if ($type == 'png') {
		//Check signature
		if(substr($data,0,8)!=$this->chrs[137].'PNG'.$this->chrs[13].$this->chrs[10].$this->chrs[26].$this->chrs[10]) { 
			return $this->_imageError($file, $firsttime, 'Error parsing PNG identifier'); 
		}
		//Read header chunk
		if(substr($data,12,4)!='IHDR') { 
			return $this->_imageError($file, $firsttime, 'Incorrect PNG file (no IHDR block found)'); 
		}
		$w=$this->_fourbytes2int(substr($data,16,4));
		$h=$this->_fourbytes2int(substr($data,20,4));
		$bpc=$this->ords[substr($data,24,1)];
		$errpng = false;
		$pngalpha = false; 
		if($bpc>8) { $errpng = 'not 8-bit depth'; }
		$ct=$this->ords[substr($data,25,1)];
		if($ct==0) { $colspace='DeviceGray'; }
		elseif($ct==2) { $colspace='DeviceRGB'; }
		elseif($ct==3) { $colspace='Indexed'; }
		else { $errpng = 'alpha channel'; $pngalpha = true; } 
		if($this->ords[substr($data,26,1)]!=0) { $errpng = 'compression method'; }
		if($this->ords[substr($data,27,1)]!=0) { $errpng = 'filter method'; }
		if($this->ords[substr($data,28,1)]!=0) { $errpng = 'interlaced file'; }
		if ($errpng || $pngalpha) {
			if (function_exists('gd_info')) { $gd = gd_info(); }
			else {$gd = array(); }
			if (!isset($gd['PNG Support'])) { return $this->_imageError($file, $firsttime, 'GD library required for PNG image ('.$errpng.')'); }
			$im = imagecreatefromstring($data);
			if (!$im) { return $this->_imageError($file, $firsttime, 'Error creating GD image from PNG file ('.$errpng.')'); }
			$w = imagesx($im);
			$h = imagesy($im);
			if ($im) {
			   $tempfile = _MPDF_TEMP_PATH.'_tempImgPNG'.RAND(1,10000).'.png';
			   // Alpha channel set
			   if ($pngalpha) {
				if ($this->PDFA) { $this->Error("PDFA1-b does not permit images with alpha channel transparency (".$file.")."); }
				$imgalpha = imagecreate($w, $h);
				// generate gray scale pallete
				for ($c = 0; $c < 256; ++$c) { ImageColorAllocate($imgalpha, $c, $c, $c); }
				// extract alpha channel
				for ($xpx = 0; $xpx < $w; ++$xpx) {
					for ($ypx = 0; $ypx < $h; ++$ypx) {
						$colorindex = imagecolorat($im, $xpx, $ypx);
						$col = imagecolorsforindex($im, $colorindex);
						$gammacorr = 2.2;	// gamma correction
						$gamma = (pow((((127 - $col['alpha']) * 255 / 127) / 255), $gammacorr) * 255);
						imagesetpixel($imgalpha, $xpx, $ypx, $gamma);
					}
				}
				// create temp alpha file
	 		 	$tempfile_alpha = _MPDF_TEMP_PATH.'_tempMskPNG'.RAND(1,10000).'.png';
				// mPDF 5.0
				if (!is_writable($tempfile_alpha)) { 
					ob_start(); 
					$check = @imagepng($imgalpha);
					if (!$check) { return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse PNG image'); }
					imagedestroy($imgalpha);
					$this->_tempimg = ob_get_contents();
					$this->_tempimglnk = 'var:_tempimg';
					ob_end_clean();
					// extract image without alpha channel
					$imgplain = imagecreatetruecolor($w, $h);
					imagecopy($imgplain, $im, 0, 0, 0, 0, $w, $h);
					// create temp image file
					$minfo = $this->_getImage($this->_tempimglnk, false);
					if (!$minfo) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse PNG image'); }
					ob_start(); 
					$check = @imagepng($imgplain);
					if (!$check) { return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse PNG image'); }
					$this->_tempimg = ob_get_contents();
					$this->_tempimglnk = 'var:_tempimg';
					ob_end_clean();
					$info = $this->_getImage($this->_tempimglnk, false);
					if (!$info) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse PNG image'); }
					imagedestroy($imgplain);
					$imgmask = count($this->images)+1;
					$minfo['cs'] = 'DeviceGray';
					$minfo['i']=$imgmask ;
					$this->images[$tempfile_alpha] = $minfo;

				}
				else {
					$check = @imagepng($imgalpha, $tempfile_alpha);
					if (!$check) { return $this->_imageError($file, $firsttime, 'Failed to create temporary image file ('.$tempfile_alpha.') parsing PNG image with alpha channel ('.$errpng.')'); }
					imagedestroy($imgalpha);

					// extract image without alpha channel
					$imgplain = imagecreatetruecolor($w, $h);
					imagecopy($imgplain, $im, 0, 0, 0, 0, $w, $h);

					// create temp image file
					$check = @imagepng($imgplain, $tempfile);
					if (!$check) { return $this->_imageError($file, $firsttime, 'Failed to create temporary image file ('.$tempfile.') parsing PNG image with alpha channel ('.$errpng.')'); }
					imagedestroy($imgplain);
					// embed mask image
					$minfo = $this->_getImage($tempfile_alpha, false);
					unlink($tempfile_alpha);
					if (!$minfo) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file ('.$tempfile_alpha.') created with GD library to parse PNG image'); }
					$imgmask = count($this->images)+1;
					$minfo['cs'] = 'DeviceGray';
					$minfo['i']=$imgmask ;
					$this->images[$tempfile_alpha] = $minfo;
					// embed image, masked with previously embedded mask
					$info = $this->_getImage($tempfile, false);
					unlink($tempfile);
					if (!$info) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file ('.$tempfile.') created with GD library to parse PNG image'); }

				}
				$info['masked'] = $imgmask;
				$info['i']=count($this->images)+1;
				$info['type']='png';
				$this->images[$file]=$info;
				return $info;
			   }
			   else { 	// No alpha/transparency set
				imagealphablending($im, false);
				imagesavealpha($im, false); 
				imageinterlace($im, false);
				// mPDF 5.0
				if (!is_writable($tempfile)) { 
					ob_start(); 
					$check = @imagepng($im);
					if (!$check) { return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse PNG image'); }
					$this->_tempimg = ob_get_contents();
					$this->_tempimglnk = 'var:_tempimg';
					ob_end_clean();
					$info = $this->_getImage($this->_tempimglnk, false);
					if (!$info) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse PNG image'); }
					imagedestroy($im);
				}
				else {
					$check = @imagepng($im, $tempfile );
					if (!$check) { return $this->_imageError($file, $firsttime, 'Failed to create temporary image file ('.$tempfile.') parsing PNG image ('.$errpng.')'); }
					imagedestroy($im);
					$info = $this->_getImage($tempfile, false) ;
					unlink($tempfile ); 
					if (!$info) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file ('.$tempfile.') created with GD library to parse PNG image'); }
				}
				$info['i']=count($this->images)+1;
				$info['type']='png';
				$this->images[$file]=$info;
				return $info;
			   }
			}
		}

		$parms='/DecodeParms <</Predictor 15 /Colors '.($ct==2 ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w.'>>';
		//Scan chunks looking for palette, transparency and image data
		$pal='';
		$trns='';
		$pngdata='';
		$p = 33;
		do {
			$n=$this->_fourbytes2int(substr($data,$p,4));	$p += 4;
			$type=substr($data,$p,4);	$p += 4;
			if($type=='PLTE') {
				//Read palette
				$pal=substr($data,$p,$n);	$p += $n;
				$p += 4;
			}
			elseif($type=='tRNS') {
				//Read transparency info
				$t=substr($data,$p,$n);	$p += $n;
				if($ct==0) $trns=array($this->ords[substr($t,1,1)]);
				elseif($ct==2) $trns=array($this->ords[substr($t,1,1)],$this->ords[substr($t,3,1)],$this->ords[substr($t,5,1)]);
				else
				{
					$pos=strpos($t,$this->chrs[0]);
					if(is_int($pos)) $trns=array($pos);
				}
				$p += 4;
			}
			elseif($type=='IDAT') {
				$pngdata.=substr($data,$p,$n);	$p += $n;
				$p += 4;
			}
			elseif($type=='IEND') { break; }
			else if (preg_match('/[a-zA-Z]{4}/',$type)) { $p += $n+4; }
			else { return $this->_imageError($file, $firsttime, 'Error parsing PNG image data'); }
		}
		while($n);
		if (!$pngdata) { return $this->_imageError($file, $firsttime, 'Error parsing PNG image data - no IDAT data found'); }
		if($colspace=='Indexed' and empty($pal)) { return $this->_imageError($file, $firsttime, 'Error parsing PNG image data - missing colour palette'); }
		$info = array('w'=>$w,'h'=>$h,'cs'=>$colspace,'bpc'=>$bpc,'f'=>'FlateDecode','parms'=>$parms,'pal'=>$pal,'trns'=>$trns,'data'=>$pngdata);
		$info['type']='png';
		if ($firsttime) {
			$info['i']=count($this->images)+1;
			$this->images[$file]=$info;
		}
		return $info;
	}

	// GIF
	else if ($type == 'gif') {
		if (function_exists('gd_info')) { $gd = gd_info(); }
		else {$gd = array(); }
		if (isset($gd['GIF Read Support']) && $gd['GIF Read Support']) {
			$im = @imagecreatefromstring($data);
			if ($im) {
				$tempfile = _MPDF_TEMP_PATH.'_tempImgPNG'.RAND(1,10000).'.png';
				imagealphablending($im, false);
				imagesavealpha($im, false); 
				imageinterlace($im, false);
				// mPDF 5.0
				if (!is_writable($tempfile)) { 
					ob_start(); 
					$check = @imagepng($im);
					if (!$check) { return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse GIF image'); }
					$this->_tempimg = ob_get_contents();
					$this->_tempimglnk = 'var:_tempimg';
					ob_end_clean();
					$info = $this->_getImage($this->_tempimglnk, false);
					if (!$info) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse GIF image'); }
					imagedestroy($im);
				}
				else {
					$check = @imagepng($im, $tempfile);
					if (!$check) { return $this->_imageError($file, $firsttime, 'Error creating temporary file ('.$tempfile.') whilst using GD library to parse GIF image'); }
					$info = $this->_getImage($tempfile, false);
					if (!$info) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file ('.$tempfile.') created with GD library to parse GIF image'); }
					imagedestroy($im);
					unlink($tempfile);
				}
				$info['type']='gif';
				if ($firsttime) {
					$info['i']=count($this->images)+1;
					$this->images[$file]=$info;
				}
				return $info;
			}
			else { return $this->_imageError($file, $firsttime, 'Error creating GD image file from GIF image'); }
		}

		if (!class_exists('gif', false)) { 
			include_once(_MPDF_PATH.'classes/gif.php'); 
			$gif=new CGIF();
		}

		$h=0;
		$w=0;
		$gif->loadFile($data, 0);

		if(isset($gif->m_img->m_gih->m_bLocalClr) && $gif->m_img->m_gih->m_bLocalClr) {
			$nColors = $gif->m_img->m_gih->m_nTableSize;
			$pal = $gif->m_img->m_gih->m_colorTable->toString();
			if($bgColor != -1) {
				$bgColor = $gif->m_img->m_gih->m_colorTable->colorIndex($bgColor);
			}
			$colspace='Indexed';
		} elseif(isset($gif->m_gfh->m_bGlobalClr) && $gif->m_gfh->m_bGlobalClr) {
			$nColors = $gif->m_gfh->m_nTableSize;
			$pal = $gif->m_gfh->m_colorTable->toString();
			if((isset($bgColor)) and $bgColor != -1) {
				$bgColor = $gif->m_gfh->m_colorTable->colorIndex($bgColor);
			}
			$colspace='Indexed';
		} else {
			$nColors = 0;
			$bgColor = -1;
			$colspace='DeviceGray';
			$pal='';
		}

		$trns='';
		if(isset($gif->m_img->m_bTrans) && $gif->m_img->m_bTrans && ($nColors > 0)) {
			$trns=array($gif->m_img->m_nTrans);
		}
		$gifdata=$gif->m_img->m_data;
		$w=$gif->m_gfh->m_nWidth;
		$h=$gif->m_gfh->m_nHeight;
		$gif->ClearData();

		if($colspace=='Indexed' and empty($pal)) {
			return $this->_imageError($file, $firsttime, 'Error parsing GIF image - missing colour palette'); 
		}
		if ($this->compress) {
			$gifdata=gzcompress($gifdata);
			$info = array( 'w'=>$w, 'h'=>$h, 'cs'=>$colspace, 'bpc'=>8, 'f'=>'FlateDecode', 'pal'=>$pal, 'trns'=>$trns, 'data'=>$gifdata);
		} 
		else {
			$info = array( 'w'=>$w, 'h'=>$h, 'cs'=>$colspace, 'bpc'=>8, 'pal'=>$pal, 'trns'=>$trns, 'data'=>$gifdata);
		} 
		$info['type']='gif';
		if ($firsttime) {
			$info['i']=count($this->images)+1;
			$this->images[$file]=$info;
		}
		return $info;
	}


	// BMP (Windows Bitmap)
	else if ($type == 'bmp') {
		// Adapted from script by Valentin Schmidt
		// http://staff.dasdeck.de/valentin/fpdf/fpdf_bmp/
		$bfOffBits=$this->_fourbytes2int_le(substr($data,10,4));
		$width=$this->_fourbytes2int_le(substr($data,18,4));
		$height=$this->_fourbytes2int_le(substr($data,22,4));
		$flip = ($height<0);
		if ($flip) $height =-$height;
		$biBitCount=$this->_twobytes2int_le(substr($data,28,2));
		$biCompression=$this->_fourbytes2int_le(substr($data,30,4)); 
		$info = array('w'=>$width, 'h'=>$height);
		if ($biBitCount<16){
			$info['cs'] = 'Indexed';
			$info['bpc'] = $biBitCount;
			$palStr = substr($data,54,($bfOffBits-54));
			$pal = '';
			$cnt = strlen($palStr)/4;
			for ($i=0;$i<$cnt;$i++){
				$n = 4*$i;
				$pal .= $palStr[$n+2].$palStr[$n+1].$palStr[$n];
			}
			$info['pal'] = $pal;
		}
		else{
			$info['cs'] = 'DeviceRGB';
			$info['bpc'] = 8;
		}
		switch ($biCompression){
		  case 0:
			$str = substr($data,$bfOffBits);
			break;
		  case 1: # BI_RLE8
			$str = $this->rle8_decode(substr($data,$bfOffBits), $width);
			break;
		  case 2: # BI_RLE4
			$str = $this->rle4_decode(substr($data,$bfOffBits), $width);
			break;
		}
		$bmpdata = '';
		$padCnt = (4-ceil(($width/(8/$biBitCount)))%4)%4;
		switch ($biBitCount){
		  case 1:
		  case 4:
		  case 8:
			$w = floor($width/(8/$biBitCount)) + ($width%(8/$biBitCount)?1:0);
			$w_row = $w + $padCnt;
			if ($flip){
				for ($y=0;$y<$height;$y++){
					$y0 = $y*$w_row;
					for ($x=0;$x<$w;$x++)
						$bmpdata .= $str[$y0+$x];
				}
			}else{
				for ($y=$height-1;$y>=0;$y--){
					$y0 = $y*$w_row;
					for ($x=0;$x<$w;$x++)
						$bmpdata .= $str[$y0+$x];
				}
			}
			break;

		  case 16:
			$w_row = $width*2 + $padCnt;
			if ($flip){
				for ($y=0;$y<$height;$y++){
					$y0 = $y*$w_row;
					for ($x=0;$x<$width;$x++){
						$n = (ord( $str[$y0 + 2*$x + 1])*256 +    ord( $str[$y0 + 2*$x]));
						$b = ($n & 31)<<3; $g = ($n & 992)>>2; $r = ($n & 31744)>>7128;
						$bmpdata .= chr($r) . chr($g) . chr($b);
					}
				}
			}else{
				for ($y=$height-1;$y>=0;$y--){
					$y0 = $y*$w_row;
					for ($x=0;$x<$width;$x++){
						$n = (ord( $str[$y0 + 2*$x + 1])*256 +    ord( $str[$y0 + 2*$x]));
						$b = ($n & 31)<<3; $g = ($n & 992)>>2; $r = ($n & 31744)>>7;
						$bmpdata .= chr($r) . chr($g) . chr($b);
					}
				}
			}
			break;

		  case 24:
		  case 32:
			$byteCnt = $biBitCount/8;
			$w_row = $width*$byteCnt + $padCnt;

			if ($flip){
				for ($y=0;$y<$height;$y++){
					$y0 = $y*$w_row;
					for ($x=0;$x<$width;$x++){
						$i = $y0 + $x*$byteCnt ; # + 1
						$bmpdata .= $str[$i+2].$str[$i+1].$str[$i];
					}
				}
			}else{
				for ($y=$height-1;$y>=0;$y--){
					$y0 = $y*$w_row;
					for ($x=0;$x<$width;$x++){
						$i = $y0 + $x*$byteCnt ; # + 1
						$bmpdata .= $str[$i+2].$str[$i+1].$str[$i];
					}
				}
			}
			break;

		  default:
			return $this->_imageError($file, $firsttime, 'Error parsing BMP image - Unsupported image biBitCount'); 
		}
		if ($this->compress) {
			$bmpdata=gzcompress($bmpdata);
			$info['f']='FlateDecode';
		} 
		$info['data']=$bmpdata;
		$info['type']='bmp';
		if ($firsttime) {
			$info['i']=count($this->images)+1;
			$this->images[$file]=$info;
		}
		return $info;
	}


	// UNKNOWN TYPE - try GD imagecreatefromstring
	else {
		if (function_exists('gd_info')) { $gd = gd_info(); }
		else {$gd = array(); }
		if (isset($gd['PNG Support']) && $gd['PNG Support']) {
			$im = @imagecreatefromstring($data);
			if (!$im) { return $this->_imageError($file, $firsttime, 'Error parsing image file - image type not recognised, and not supported by GD imagecreate'); }
			$tempfile = _MPDF_TEMP_PATH.'_tempImgPNG'.RAND(1,10000).'.png';
			imagealphablending($im, false);
			imagesavealpha($im, false); 
			imageinterlace($im, false);
			$check = @imagepng($im, $tempfile);
			if (!$check) { return $this->_imageError($file, $firsttime, 'Error creating temporary file ('.$tempfile.') whilst using GD library to parse unknown image type'); }
			$info = $this->_getImage($tempfile, false);
			imagedestroy($im);
			unlink($tempfile);
			if (!$info) { return $this->_imageError($file, $firsttime, 'Error parsing temporary file ('.$tempfile.') created with GD library to parse unknown image type'); }
			$info['type']='png';
			if ($firsttime) {
				$info['i']=count($this->images)+1;
				$this->images[$file]=$info;
			}
			return $info;
		}
	}

	return $this->_imageError($file, $firsttime, 'Error parsing image file - image type not recognised'); 
}
//==============================================================


# Decoder for RLE8 compression in windows bitmaps
# see http://msdn.microsoft.com/library/default.asp?url=/library/en-us/gdi/bitmaps_6x0u.asp
function rle8_decode ($str, $width){
    $lineWidth = $width + (3 - ($width-1) % 4);
    $out = '';
    $cnt = strlen($str);
    for ($i=0;$i<$cnt;$i++){
        $o = ord($str[$i]);
        switch ($o){
            case 0: # ESCAPE
                $i++;
                switch (ord($str[$i])){
                    case 0: # NEW LINE
                         $padCnt = $lineWidth - strlen($out)%$lineWidth;
                        if ($padCnt<$lineWidth) $out .= str_repeat(chr(0), $padCnt); # pad line
                        break;
                    case 1: # END OF FILE
                        $padCnt = $lineWidth - strlen($out)%$lineWidth;
                        if ($padCnt<$lineWidth) $out .= str_repeat(chr(0), $padCnt); # pad line
                         break 3;
                    case 2: # DELTA
                        $i += 2;
                        break;
                    default: # ABSOLUTE MODE
                        $num = ord($str[$i]);
                        for ($j=0;$j<$num;$j++)
                            $out .= $str[++$i];
                        if ($num % 2) $i++;
             }
                break;
            default:
                $out .= str_repeat($str[++$i], $o);
        }
    }
    return $out;
}

# Decoder for RLE4 compression in windows bitmaps
# see http://msdn.microsoft.com/library/default.asp?url=/library/en-us/gdi/bitmaps_6x0u.asp
function rle4_decode ($str, $width){
    $w = floor($width/2) + ($width % 2);
    $lineWidth = $w + (3 - ( ($width-1) / 2) % 4);    
    $pixels = array();
    $cnt = strlen($str);
    for ($i=0;$i<$cnt;$i++){
        $o = ord($str[$i]);
        switch ($o){
            case 0: # ESCAPE
                $i++;
                switch (ord($str[$i])){
                    case 0: # NEW LINE                        
                        while (count($pixels)%$lineWidth!=0)
                            $pixels[]=0;
                        break;
                    case 1: # END OF FILE
                        while (count($pixels)%$lineWidth!=0)
                            $pixels[]=0;
                        break 3;
                    case 2: # DELTA
                        $i += 2;
                        break;
                    default: # ABSOLUTE MODE
                        $num = ord($str[$i]);
                        for ($j=0;$j<$num;$j++){
                            if ($j%2==0){
                                $c = ord($str[++$i]);
                              $pixels[] = ($c & 240)>>4;
                             } else
                              $pixels[] = $c & 15;
                        }
                        if ($num % 2) $i++;
             }
                break;
            default:
                $c = ord($str[++$i]);
                for ($j=0;$j<$o;$j++)
                    $pixels[] = ($j%2==0 ? ($c & 240)>>4 : $c & 15);
        }
    }
    
    $out = '';
    if (count($pixels)%2) $pixels[]=0;
    $cnt = count($pixels)/2;
    for ($i=0;$i<$cnt;$i++)
        $out .= chr(16*$pixels[2*$i] + $pixels[2*$i+1]);
    return $out;
} 

function _fourbytes2int_le($s) {
	//Read a 4-byte integer from string
	return (ord($s[3])<<24) + (ord($s[2])<<16) + (ord($s[1])<<8) + ord($s[0]);
}

function _twobytes2int_le($s) {
	//Read a 2-byte integer from string
	return (ord(substr($s, 1, 1))<<8) + ord(substr($s, 0, 1));
}


function _fourbytes2int($s) {
	//Read a 4-byte integer from string
	return (ord($s[0])<<24) + (ord($s[1])<<16) + (ord($s[2])<<8) + ord($s[3]);
}

function _twobytes2int($s) {
	//Read a 2-byte integer from string
	return (ord(substr($s, 0, 1))<<8) + ord(substr($s, 1, 1));
}

function _jpgHeaderFromString(&$data) {
	$p = 4;
	$p += $this->_twobytes2int(substr($data, $p, 2));	// Length of initial marker block
	$marker = substr($data, $p, 2);
	while($marker != chr(255).chr(192) && $marker != chr(255).chr(194) && $p<strlen($data)) {
		// Start of frame marker (FFC0) or (FFC2) mPDF 4.4.004
		$p += ($this->_twobytes2int(substr($data, $p+2, 2))) + 2;	// Length of marker block
		$marker = substr($data, $p, 2);
	}
	if ($marker != chr(255).chr(192) && $marker != chr(255).chr(194)) { return false; }
	return substr($data, $p+2, 10);
}

function _jpgDataFromHeader($hdr) {
	$bpc = ord(substr($hdr, 2, 1));
	if (!$bpc) { $bpc = 8; }
	$h = $this->_twobytes2int(substr($hdr, 3, 2));
	$w = $this->_twobytes2int(substr($hdr, 5, 2));
	$channels = ord(substr($hdr, 7, 1));
	if ($channels==3) { $colspace='DeviceRGB'; }
	elseif($channels==4) { $colspace='DeviceCMYK'; }
	else { $colspace='DeviceGray'; }
	return array($w, $h, $colspace, $bpc);
}

function file_get_contents_by_curl($url, &$data) {
	$timeout = 5;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_NOBODY, 0);
	curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , 1 );
	curl_setopt ( $ch , CURLOPT_CONNECTTIMEOUT , $timeout );
	$data = curl_exec($ch);
	curl_close($ch);
}


function file_get_contents_by_socket($url, &$data) {
	$timeout = 1;
	$p = parse_url($url);
	$file = $p['path'];
	if ($p['query']) { $file .= '?'.$p['query']; }
	if(!($fh = @fsockopen($p['host'], 80, $errno, $errstr, $timeout))) { return false; }
	$getstring =
		"GET ".$file." HTTP/1.0 \r\n" .
		"Host: ".$p['host']." \r\n" .
		"Connection: close\r\n\r\n";
	fwrite($fh, $getstring);
	// Get rid of HTTP header
	$s = fgets($fh, 1024);
	if (!$s) { return false; }
	$httpheader .= $s;
	while (!feof($fh)) {
		$s = fgets($fh, 1024);
		if ( $s == "\r\n" ) { break; }
	}
	$data = '';
	while (!feof($fh)) {
		$data .= fgets($fh, 1024);
	}
	fclose($fh);
}

//==============================================================

function _imageTypeFromString(&$data) {
	$type = '';
	if (substr($data, 6, 4)== 'JFIF' || substr($data, 6, 4)== 'Exif') { 
		$type = 'jpeg'; 
	}
	else if (substr($data, 0, 6)== "GIF87a" || substr($data, 0, 6)== "GIF89a") { 
		$type = 'gif';
	}
	else if (substr($data, 0, 8)== chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10)) { 
		$type = 'png';
	}
	else if (preg_match('/<svg.*<\/svg>/is',$data)) { 
		$type = 'svg';
	}
	// BMP images
	else if (substr($data, 0, 2)== "BM") { 
		$type = 'bmp';
	}
	return $type;
}
//==============================================================


// Moved outside WMF as also needed for SVG
function _putformobjects() {
	reset($this->formobjects);
	while(list($file,$info)=each($this->formobjects)) {
		$this->_newobj();
		$this->formobjects[$file]['n']=$this->n;
		$this->_out('<</Type /XObject');
		$this->_out('/Subtype /Form');
		$this->_out('/Group '.($this->n+1).' 0 R');
		$this->_out('/BBox ['.$info['x'].' '.$info['y'].' '.($info['w']+$info['x']).' '.($info['h']+$info['y']).']');
		if ($this->compress)
			$this->_out('/Filter /FlateDecode');
		$data=($this->compress) ? gzcompress($info['data']) : $info['data'];
		$this->_out('/Length '.strlen($data).'>>');
		$this->_putstream($data);
		unset($this->formobjects[$file]['data']);
		$this->_out('endobj');
		// Required for SVG transparency (opacity) to work
		$this->_newobj();
		$this->_out('<</Type /Group');
		$this->_out('/S /Transparency');
		$this->_out('>>');
		$this->_out('endobj');
	}
}

function _freadint($f)
{
	//Read a 4-byte integer from file
	$i=$this->ords[fread($f,1)]<<24;
	$i+=$this->ords[fread($f,1)]<<16;
	$i+=$this->ords[fread($f,1)]<<8;
	$i+=$this->ords[fread($f,1)];
	return $i;
}

function _UTF16BEtextstring($s) {
	$s = $this->UTF8ToUTF16BE($s, true);
	return '('. $this->_escape($s).')';
}

function _textstring($s) {
	return '('. $this->_escape($s).')';
}


function _escape($s)
{
	// the chr(13) substitution fixes the Bugs item #1421290.
	return strtr($s, array(')' => '\\)', '(' => '\\(', '\\' => '\\\\', $this->chrs[13] => '\r'));
}

function _putstream($s) {
	$this->_out('stream');
	$this->_out($s);
	$this->_out('endstream');
}


function _out($s,$ln=true) {
	if($this->state==2) {
	   if ($this->bufferoutput) {
		$this->headerbuffer.= $s."\n";
	   }
	   else if ($this->kwt && !$this->processingHeader && !$this->processingFooter) {
		// Captures eveything in buffer for keep-with-table (h1-6); 
		$this->kwt_buffer[] = array(
		's' => $s,							// Text string to output 
		'x' => $this->x, 						// x when printed  
		'y' => $this->y,					 	// y when printed  
		);
	   }
	   else if (($this->keep_block_together) && (!$this->processingHeader) && (!$this->processingFooter)) {
		if (!isset($this->ktBlock[$this->page]['bottom_margin'])) {
			$this->ktBlock[$this->page]['bottom_margin'] = $this->y;
		}

		// Captures eveything in buffer; 
		if (preg_match('/q \d+\.\d\d+ 0 0 (\d+\.\d\d+) \d+\.\d\d+ \d+\.\d\d+ cm \/(I|FO)\d+ Do Q/',$s,$m)) {	// Image data 
			$h = ($m[1]/$this->k);
			// Update/overwrite the lowest bottom of printing y value for Keep together block
			$this->ktBlock[$this->page]['bottom_margin'] = $this->y+$h;
		}
		else { 	// Td Text Set in Cell()
			if (isset($this->ktBlock[$this->page]['bottom_margin'])) { $h = $this->ktBlock[$this->page]['bottom_margin'] - $this->y; }
			else { $h = 0; }
		}
		if ($h < 0) { $h = -$h; }
		$this->divbuffer[] = array(
		'page' => $this->page,
		's' => $s,							// Text string to output 
		'x' => $this->x, 						// x when printed 
		'y' => $this->y,					 	// y when printed (after column break)
		'h' => $h						 	// actual y at bottom when printed = y+h
		);
	   }
	   else {
		$this->pages[$this->page] .= $s.($ln == true ? "\n" : '');
	   }

	}
	else {
		$this->buffer .= $s.($ln == true ? "\n" : '');
	}
}



function Rotate($angle,$x=-1,$y=-1)
{
	if($x==-1)
		$x=$this->x;
	if($y==-1)
		$y=$this->y;
	if($this->angle!=0)
		$this->_out('Q');
	$this->angle=$angle;
	if($angle!=0)
	{
		$angle*=M_PI/180;
		$c=cos($angle);
		$s=sin($angle);
		$cx=$x*$this->k;
		$cy=($this->h-$y)*$this->k;
		$this->_out(sprintf('q %.5f %.5f %.5f %.5f %.3f %.3f cm 1 0 0 1 %.3f %.3f cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
	}
}

// From Invoice
function RoundedRect($x, $y, $w, $h, $r, $style = '')
{
	$k = $this->k;
	$hp = $this->h;
	if($style=='F')
		$op='f';
	elseif($style=='FD' or $style=='DF')
		$op='B';
	else
		$op='S';
	$MyArc = 4/3 * (sqrt(2) - 1);
	$this->_out(sprintf('%.3f %.3f m',($x+$r)*$k,($hp-$y)*$k ));
	$xc = $x+$w-$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.3f %.3f l', $xc*$k,($hp-$y)*$k ));

	$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
	$xc = $x+$w-$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.3f %.3f l',($x+$w)*$k,($hp-$yc)*$k));
	$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
	$xc = $x+$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.3f %.3f l',$xc*$k,($hp-($y+$h))*$k));
	$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
	$xc = $x+$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.3f %.3f l',($x)*$k,($hp-$yc)*$k ));
	$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
	$this->_out($op);
}

function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
{
	$h = $this->h;
	$this->_out(sprintf('%.3f %.3f %.3f %.3f %.3f %.3f c ', $x1*$this->k, ($h-$y1)*$this->k,
						$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
}




//====================================================





function UTF8StringToArray($str, $addSubset=true) {
   $out = array();
   $len = strlen($str);
   for ($i = 0; $i < $len; $i++) {
	$uni = -1;
      $h = ord($str[$i]);
      if ( $h <= 0x7F )
         $uni = $h;
      elseif ( $h >= 0xC2 ) {
         if ( ($h <= 0xDF) && ($i < $len -1) )
            $uni = ($h & 0x1F) << 6 | (ord($str[++$i]) & 0x3F);
         elseif ( ($h <= 0xEF) && ($i < $len -2) )
            $uni = ($h & 0x0F) << 12 | (ord($str[++$i]) & 0x3F) << 6
                                       | (ord($str[++$i]) & 0x3F);
         elseif ( ($h <= 0xF4) && ($i < $len -3) )
            $uni = ($h & 0x0F) << 18 | (ord($str[++$i]) & 0x3F) << 12
                                       | (ord($str[++$i]) & 0x3F) << 6
                                       | (ord($str[++$i]) & 0x3F);
      }
	if ($uni >= 0) {
		$out[] = $uni;
		if ($addSubset && isset($this->CurrentFont['subset'])) {	// mPDF 5.0
			$this->CurrentFont['subset'][$uni] = $uni;
		}
	}
   }
   return $out;
}

//Convert utf-8 string to <HHHHHH> for Font Subsets
function UTF8toSubset($str) {
	$ret = '<';
	$str = preg_replace('/'.preg_quote($this->aliasNbPg,'/').'/', chr(7), $str );
	$str = preg_replace('/'.preg_quote($this->aliasNbPgGp,'/').'/', chr(8), $str );
	$unicode = $this->UTF8StringToArray($str);
	$orig_fid = $this->CurrentFont['subsetfontids'][0];
	$last_fid = $this->CurrentFont['subsetfontids'][0];
	foreach($unicode as $c) {
	   if ($c == 7 || $c == 8) { 
			if ($orig_fid != $last_fid) {
				$ret .= '> Tj /F'.$orig_fid.' '.$this->FontSizePt.' Tf <';
				$last_fid = $orig_fid;
			}
			if ($c == 7) { $ret .= $this->aliasNbPgHex; }	// mPDF 5.0.04
			else { $ret .= $this->aliasNbPgGpHex; }	// mPDF 5.0.04
			continue;
	   }
	   for ($i=0; $i<99; $i++) {
		// return c as decimal char
		$init = array_search($c, $this->CurrentFont['subsets'][$i]);
		if ($init!==false) {
			if ($this->CurrentFont['subsetfontids'][$i] != $last_fid) {
				$ret .= '> Tj /F'.$this->CurrentFont['subsetfontids'][$i].' '.$this->FontSizePt.' Tf <';
				$last_fid = $this->CurrentFont['subsetfontids'][$i];
			}
			$ret .= sprintf("%02s", strtoupper(dechex($init)));
			break;
		}
		// TrueType embedded SUBSETS
		else if (count($this->CurrentFont['subsets'][$i]) < 255) {
			$n = count($this->CurrentFont['subsets'][$i]);
			$this->CurrentFont['subsets'][$i][$n] = $c;
			if ($this->CurrentFont['subsetfontids'][$i] != $last_fid) {
				$ret .= '> Tj /F'.$this->CurrentFont['subsetfontids'][$i].' '.$this->FontSizePt.' Tf <';
				$last_fid = $this->CurrentFont['subsetfontids'][$i];
			}
			$ret .= sprintf("%02s", strtoupper(dechex($n)));
			break;
		}
		else if (!isset($this->CurrentFont['subsets'][($i+1)])) {
			// TrueType embedded SUBSETS
			$this->CurrentFont['subsets'][($i+1)] = array(0=>0);
			$new_fid = count($this->fonts)+$this->extraFontSubsets+1;
			$this->CurrentFont['subsetfontids'][($i+1)] = $new_fid;
			$this->extraFontSubsets++;
		}
	   }
	}
	$ret .= '>';
	if ($last_fid != $orig_fid) {
		$ret .= ' Tj /F'.$orig_fid.' '.$this->FontSizePt.' Tf <> ';
	}
	return $ret;
}


// Converts UTF-8 strings to UTF16-BE.
function UTF8ToUTF16BE($str, $setbom=true) {
	// mPDF 5.0
	if ($this->checkSIP && preg_match("/([\x{20000}-\x{2FFFF}])/u", $str)) { 
	   if (!in_array($this->currentfontfamily, array('gb','big5','sjis','uhc','gbB','big5B','sjisB','uhcB','gbI','big5I','sjisI','uhcI',
		'gbBI','big5BI','sjisBI','uhcBI'))) {
		$str = preg_replace("/[\x{20000}-\x{2FFFF}]/u", chr(0), $str);
	   }
	}
	// mPDF 5.0.03
	if ($this->checkSMP && preg_match("/([\x{10000}-\x{1FFFF}])/u", $str )) { 
		$str = preg_replace("/[\x{10000}-\x{1FFFF}]/u", chr(0), $str );
	}
	$outstr = ""; // string to be returned
	if ($setbom) {
		$outstr .= "\xFE\xFF"; // Byte Order Mark (BOM)
	}
	$outstr .= mb_convert_encoding($str, 'UTF-16BE', 'UTF-8');
	return $outstr;
}





// ====================================================
// ====================================================

// from class PDF_Chinese CJK EXTENSIONS



function AddCIDFont($family,$style,$name,&$cw,$CMap,$registry,$desc)
{
	$fontkey=strtolower($family).strtoupper($style);
	if(isset($this->fonts[$fontkey]))
		$this->Error("Font already added: $family $style");
	$i=count($this->fonts)+$this->extraFontSubsets+1;
	$name=str_replace(' ','',$name);
	if ($family == 'sjis') { $up = -120; } else { $up = -130; }
	// ? 'up' and 'ut' do not seem to be referenced anywhere
	$this->fonts[$fontkey]=array('i'=>$i,'type'=>'Type0','name'=>$name,'up'=>$up,'ut'=>40,'cw'=>$cw,'CMap'=>$CMap,'registry'=>$registry,'MissingWidth'=>1000,'desc'=>$desc);
}

function AddCJKFont($family) {

	if ($this->PDFA) {
		$this->Error("Adobe CJK fonts cannot be embedded in mPDF (required for PDFA1-b).");
	}
	if ($family == 'big5') { $this->AddBig5Font(); }
	else if ($family == 'gb') { $this->AddGBFont(); }
	else if ($family == 'sjis') { $this->AddSJISFont(); }
	else if ($family == 'uhc') { $this->AddUHCFont(); }
}

function AddBig5Font()
{
	//Add Big5 font with proportional Latin
	$family='big5';
	$name='MSungStd-Light-Acro';	// AdobeMingStd-Light-Acro
	$cw=$this->Big5_widths;
	$CMap='UniCNS-UTF16-H';
	$desc = array(
	'Ascent' => 880,
	'Descent' => -120,
	'CapHeight' => 880,
	'Flags' => 6,
	'FontBBox' => '[-160 -249 1015 1071]',
	'ItalicAngle' => 0,
	'StemV' => 93,
	);
	$registry=array('ordering'=>'CNS1','supplement'=>0);
	$this->AddCIDFont($family,'',$name,$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'B',$name.',Bold',$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'I',$name.',Italic',$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'BI',$name.',BoldItalic',$cw,$CMap,$registry,$desc);
}


function AddGBFont()
{
	//Add GB font with proportional Latin
	$family='gb';
	$name='STSongStd-Light-Acro';		// AdobeSongStd-Light-Acro
	$cw=$this->GB_widths;
	$CMap='UniGB-UTF16-H';
	$registry=array('ordering'=>'GB1','supplement'=>2);
	$desc = array(
	'Ascent' => 752,
	'Descent' => -271,
	'CapHeight' => 737,
	'Flags' => 6,
	'FontBBox' => '[-25 -254 1000 880]',
	'ItalicAngle' => 0,
	'StemV' => 58,
	'Style' => '<< /Panose <000000000400000000000000> >>',
	);
	$this->AddCIDFont($family,'',$name,$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'B',$name.',Bold',$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'I',$name.',Italic',$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'BI',$name.',BoldItalic',$cw,$CMap,$registry,$desc);
}


function AddSJISFont()
{
	//Add SJIS font with proportional Latin
	$family='sjis';
	$name='KozMinPro-Regular-Acro';	// KozGoPro-Medium-Acro
	$cw=$this->SJIS_widths;
	$CMap='UniJIS-UTF16-H';
	$desc = array(
	'Ascent' => 880,
	'Descent' => -120,
	'CapHeight' => 740,
	'Flags' => 6,
	'FontBBox' => '[-195 -272 1110 1075]',
	'ItalicAngle' => 0,
	'StemV' => 86,
	'XHeight' => 502,
	);
	$registry=array('ordering'=>'Japan1','supplement'=>2);
	$this->AddCIDFont($family,'',$name,$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'B',$name.',Bold',$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'I',$name.',Italic',$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'BI',$name.',BoldItalic',$cw,$CMap,$registry,$desc);
}

function AddUHCFont()
{
	//Add UHC font with proportional Latin
	$family='uhc';
	$name='HYSMyeongJoStd-Medium-Acro';	// AdobeMyungjoStd-Medium-Acro
	$cw=$this->UHC_widths;
	//$CMap='KSCms-UHC-H';
	$CMap='UniKS-UTF16-H';
	$registry=array('ordering'=>'Korea1','supplement'=>1);
	$desc = array(
	'Ascent' => 880,
	'Descent' => -120,
	'CapHeight' => 720,
	'Flags' => 6,
	'FontBBox' => '[-28 -148 1001 880]',
	'ItalicAngle' => 0,
	'StemV' => 60,
	'Style' => '<< /Panose <000000000600000000000000> >>',
	);
	$this->AddCIDFont($family,'',$name,$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'B',$name.',Bold',$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'I',$name.',Italic',$cw,$CMap,$registry,$desc);
	$this->AddCIDFont($family,'BI',$name.',BoldItalic',$cw,$CMap,$registry,$desc);
}






//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
function SetAutoFont($af = AUTOFONT_ALL) {
	if ($this->onlyCoreFonts) { return false; }
	if (!$af && $af !== 0) { $af = AUTOFONT_ALL; }
	$this->autoFontGroups = $af;
	if ($this->autoFontGroups ) { 
		$this->useLang = true;
	}
}


function SetDefaultFont($font) {
	// Disallow embedded fonts to be used as defaults in PDFA
	if ($this->PDFA) {
		if (strtolower($font) == 'ctimes') { $font = 'serif'; }
		if (strtolower($font) == 'ccourier') { $font = 'monospace'; }
		if (strtolower($font) == 'chelvetica') { $font = 'sans-serif'; }
	}
  	$font = $this->SetFont($font);	// returns substituted font if necessary
	$this->default_font = $font;
	$this->original_default_font = $font;
	$this->defaultCSS['BODY']['FONT-FAMILY'] = $font;
	$this->CSS['BODY']['FONT-FAMILY'] = $font;
}

function SetDefaultFontSize($fontsize) {
	$this->default_font_size = $fontsize;
	$this->original_default_font_size = $fontsize;
	$this->SetFontSize($fontsize);
	$this->defaultCSS['BODY']['FONT-SIZE'] = $fontsize . 'pt';
	$this->CSS['BODY']['FONT-SIZE'] = $fontsize . 'pt';
}

function SetDefaultBodyCSS($prop, $val) {
   if ($prop) {
	$this->defaultCSS['BODY'][strtoupper($prop)] = $val;
	$this->CSS['BODY'][strtoupper($prop)] = $val;
  }
}


function SetDirectionality($dir='ltr') {
		$this->directionality = 'ltr'; 
		$this->defaultAlign = 'L';
		$this->defaultTableAlign = 'L';
}

function reverse_align(&$align) {
	if (strtolower($align) == 'right') { $align = 'left'; }
	else if (strtolower($align) == 'left') { $align = 'right'; }
	if (strtoupper($align) == 'R') { $align = 'L'; }
	else if (strtoupper($align) == 'L') { $align = 'R'; }
}


// Added to set line-height-correction
function SetLineHeightCorrection($val) {
	if ($val > 0) { $this->default_lineheight_correction = $val; }
	else { $this->default_lineheight_correction = 1.2; }
}

// Set a (fixed) lineheight to an actual value - either to named fontsize(pts) or default
function SetLineHeight($FontPt='',$spacing = '') {
   if ($this->shrin_k > 1) { $k = $this->shrin_k; }
   else { $k = 1; }
   if ($spacing > 0) { 
	if (preg_match('/mm/',$spacing)) { 
		$this->lineheight = ($spacing + 0.0) / $k; // convert to number
	}
	else  { 
		if ($FontPt) { $this->lineheight = (($FontPt/$this->k) *$spacing); }
		else { $this->lineheight = (($this->FontSizePt/$this->k) *$spacing); }
	}
   }
   else {
	if ($FontPt) { $this->lineheight = (($FontPt/$this->k) *$this->normalLineheight); }
	else { $this->lineheight = (($this->FontSizePt/$this->k) *$this->normalLineheight); }
   }
}

function _computeLineheight($lh, $fs='') {
	if ($this->shrin_k > 1) { $k = $this->shrin_k; }
	else { $k = 1; }
	if (!$fs) { $fs = $this->FontSize; }
	if (preg_match('/mm/',$lh)) { 
		return (($lh + 0.0) / $k); // convert to number
	}
	else if ($lh > 0) { 
		return ($fs * $lh);
	}
	else if (isset($this->normalLineheight)) { return ($fs * $this->normalLineheight); }
	else return ($fs * $this->default_lineheight_correction); 
}


function SetBasePath($str='') {
  if ( isset($_SERVER['HTTP_HOST']) ) { $host = $_SERVER['HTTP_HOST']; }
  else if ( isset($_SERVER['SERVER_NAME']) ) { $host = $_SERVER['SERVER_NAME']; }
  else { $host = ''; }
  if (!$str) { 
	if ($_SERVER['SCRIPT_NAME']) { $currentPath = dirname($_SERVER['SCRIPT_NAME']); }
	else { $currentPath = dirname($_SERVER['PHP_SELF']); }
	$currentPath = str_replace("\\","/",$currentPath);
	if ($currentPath == '/') { $currentPath = ''; }
	if ($host) { $currpath = 'http://' . $host . $currentPath .'/'; }
	else { $currpath = ''; }
	$this->basepath = $currpath; 
	$this->basepathIsLocal = true; 
	return; 
  }
  $str = preg_replace('/\?.*/','',$str);
  if (!preg_match('/(http|https|ftp):\/\/.*\//i',$str)) { $str .= '/'; } 
  $str .= 'xxx';	// in case $str ends in / e.g. http://www.bbc.co.uk/
  $this->basepath = dirname($str) . "/";	// returns e.g. e.g. http://www.google.com/dir1/dir2/dir3/
  $this->basepath = str_replace("\\","/",$this->basepath); //If on Windows
  $tr = parse_url($this->basepath);
  if (isset($tr['host']) && ($tr['host'] == $host)) { $this->basepathIsLocal = true; }
  else { $this->basepathIsLocal = false; }
}


function GetFullPath(&$path,$basepath='') {
	// When parsing CSS need to pass temporary basepath - so links are relative to current stylesheet
	if (!$basepath) { $basepath = $this->basepath; }
	//Fix path value
	$path = str_replace("\\","/",$path); //If on Windows
	//Get link info and obtain its absolute path
	$regexp = '|^./|';	// Inadvertently corrects "./path/etc" and "//www.domain.com/etc"
	$path = preg_replace($regexp,'',$path);

	if(substr($path,0,1) == '#') { return; }
	if (stristr($path,"mailto:") !== false) { return; }
	if (strpos($path,"../") !== false ) { //It is a Relative Link
		$backtrackamount = substr_count($path,"../");
		$maxbacktrack = substr_count($basepath,"/") - 1;
		$filepath = str_replace("../",'',$path);
		$path = $basepath;
		//If it is an invalid relative link, then make it go to directory root
		if ($backtrackamount > $maxbacktrack) $backtrackamount = $maxbacktrack;
		//Backtrack some directories
		for( $i = 0 ; $i < $backtrackamount + 1 ; $i++ ) $path = substr( $path, 0 , strrpos($path,"/") );
		$path = $path . "/" . $filepath; //Make it an absolute path
	}
	else if( strpos($path,":/") === false || strpos($path,":/") > 10) { //It is a Local Link
		if (substr($path,0,1) == "/") { 
			$tr = parse_url($basepath);
			$root = $tr['scheme'].'://'.$tr['host'];
			$path = $root . $path; 
		}
		else { $path = $basepath . $path; }
	}
	//Do nothing if it is an Absolute Link
}


// Used for external CSS files
function _get_file($path) {
	// If local file try using local path (? quicker, but also allowed even if allow_url_fopen false)
	$contents = '';
	$contents = @file_get_contents($path);
	if ($contents) { return $contents; }
	if ($this->basepathIsLocal) {
		$tr = parse_url($path);
		$lp=getenv("SCRIPT_NAME");
		$ap=realpath($lp);
		$ap=str_replace("\\","/",$ap);
		$docroot=substr($ap,0,strpos($ap,$lp));
		// WriteHTML parses all paths to full URLs; may be local file name 
		if ($tr['scheme'] && $tr['host'] && $_SERVER["DOCUMENT_ROOT"] ) { 
			$localpath = $_SERVER["DOCUMENT_ROOT"] . $tr['path']; 
		}
		// DOCUMENT_ROOT is not returned on IIS
		else if ($docroot) {
			$localpath = $docroot . $tr['path'];
		}
		else { $localpath = $path; }
		$contents = @file_get_contents($localpath);
	}
	// if not use full URL
	else if (!$contents && !ini_get('allow_url_fopen') && function_exists("curl_init"))  {
		$ch = curl_init($path);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , 1 );
		$contents = curl_exec($ch);
		curl_close($ch);
	}
	return $contents;
}

function UseCSS($opt=true)
{
  $this->usecss=$opt;
}

function UseTableHeader($opt=true)
{
  $this->usetableheader=$opt;
}

function UsePRE($opt=true)
{
  $this->usepre=$opt;
}

function docPageNum($num = 0, $extras = false) {
	if ($num < 1) { $num = $this->page; }
	$type = '1';	// set default decimal
	$ppgno = $num;
	$suppress = 0;
	$offset = 0;

	$lastreset = 0;
	foreach($this->PageNumSubstitutions AS $psarr) {
		if ($num >= $psarr['from']) {
			if ($psarr['reset']) { 
				if ($psarr['reset']>1) { $offset = $psarr['reset']-1; }
				$ppgno = $num - $psarr['from'] + 1 + $offset; 
				$lastreset = $psarr['from'];
			}
			if ($psarr['type']) { $type = $psarr['type']; }
			if (strtoupper($psarr['suppress'])=='ON' || $psarr['suppress']==1) { $suppress = 1; }
			else if (strtoupper($psarr['suppress'])=='OFF') { $suppress = 0; }
		}
	}
	if ($suppress) { return ''; }

	foreach($this->pgsIns AS $k=>$v) {
		if ($k>$lastreset && $k<$num) {
			$ppgno -= $v;
		}
	}
	if ($type=='A') { $ppgno = $this->dec2alpha($ppgno,true); }
	else if ($type=='a') { $ppgno = $this->dec2alpha($ppgno,false);}
	else if ($type=='I') { $ppgno = $this->dec2roman($ppgno,true); }
	else if ($type=='i') { $ppgno = $this->dec2roman($ppgno,false); }
	if ($extras) { $ppgno = $this->pagenumPrefix . $ppgno . $this->pagenumSuffix; }
	return $ppgno;
}


function docPageSettings($num = 0) {
	// Returns current type (numberstyle), suppression state for this page number; 
	// reset is only returned if set for this page number
	if ($num < 1) { $num = $this->page; }
	$type = '1';	// set default decimal
	$ppgno = $num;
	$suppress = 0;
	$offset = 0;
	$reset = '';
	foreach($this->PageNumSubstitutions AS $psarr) {
		if ($num >= $psarr['from']) {
			if ($psarr['reset']) { 
				if ($psarr['reset']>1) { $offset = $psarr['reset']-1; }
				$ppgno = $num - $psarr['from'] + 1 + $offset; 
			}
			if ($psarr['type']) { $type = $psarr['type']; }
			if (strtoupper($psarr['suppress'])=='ON' || $psarr['suppress']==1) { $suppress = 1; }
			else if (strtoupper($psarr['suppress'])=='OFF') { $suppress = 0; }
		}
		if ($num == $psarr['from']) { $reset = $psarr['reset']; }
	}
	if ($suppress) { $suppress = 'on'; }
	else { $suppress = 'off'; }
	return array($type, $suppress, $reset);
}

function docPageNumTotal($num = 0, $extras = false) {
	if ($num < 1) { $num = $this->page; }
	$type = '1';	// set default decimal
	$ppgstart = 1;
	$ppgend = count($this->pages)+1; 
	$suppress = 0;
	$offset = 0;
	foreach($this->PageNumSubstitutions AS $psarr) {
		if ($num >= $psarr['from']) {
			if ($psarr['reset']) { 
				if ($psarr['reset']>1) { $offset = $psarr['reset']-1; }
				$ppgstart = $psarr['from'] + $offset; 
				$ppgend = count($this->pages)+1 + $offset; 
			}
			if ($psarr['type']) { $type = $psarr['type']; }
			if (strtoupper($psarr['suppress'])=='ON' || $psarr['suppress']==1) { $suppress = 1; }
			else if (strtoupper($psarr['suppress'])=='OFF') { $suppress = 0; }
		}
		if ($num < $psarr['from']) {
			if ($psarr['reset']) { 
				$ppgend = $psarr['from'] + $offset; 
				break;
			}
		}
	}
	if ($suppress) { return ''; }
	$ppgno = $ppgend-$ppgstart+$offset; 
	if ($extras) { $ppgno = $this->nbpgPrefix . $ppgno . $this->nbpgSuffix; }
	return $ppgno;
}

function RestartDocTemplate() {
	$this->docTemplateStart = $this->page;
}



//Page header
function Header($content='') {

	$this->cMarginL = 0;
	$this->cMarginR = 0;


  if (($this->mirrorMargins && ($this->page%2==0) && $this->HTMLHeaderE) || ($this->mirrorMargins && ($this->page%2==1) && $this->HTMLHeader) || (!$this->mirrorMargins && $this->HTMLHeader)) {
	$this->writeHTMLHeaders(); 
	return;
  }
  $this->processingHeader=true;
  $h = $this->headerDetails;
  if(count($h)) {

	if ($this->forcePortraitHeaders && $this->CurOrientation=='L' && $this->CurOrientation!=$this->DefOrientation) {
		$this->_out(sprintf('q 0 -1 1 0 0 %.3f cm ',($this->h*$this->k)));
		$yadj = $this->w - $this->h;
		$headerpgwidth = $this->h - $this->orig_lMargin - $this->orig_rMargin;
		if (($this->mirrorMargins) && (($this->page)%2==0)) {	// EVEN
			$headerlmargin = $this->orig_rMargin;
		}
		else {
			$headerlmargin = $this->orig_lMargin;
		}
	}
	else { 
		$yadj = 0; 
		$headerpgwidth = $this->pgwidth;
		$headerlmargin = $this->lMargin;
	}

	$this->y = $this->margin_header - $yadj ;
	$this->SetTextColor(0);
    	$this->SUP = false;
	$this->SUB = false;
	$this->bullet = false;

	// only show pagenumber if numbering on
	$pgno = $this->docPageNum($this->page, true); 

	if (($this->mirrorMargins) && (($this->page)%2==0)) {	// EVEN
			$side = 'even';
	}
	else {	// ODD	// OR NOT MIRRORING MARGINS/FOOTERS = DEFAULT
			$side = 'odd';
	}
	$maxfontheight = 0;
	foreach(array('L','C','R') AS $pos) {
	  if (isset($h[$side][$pos]['content']) && $h[$side][$pos]['content']) {
		if (isset($h[$side][$pos]['font-size']) && $h[$side][$pos]['font-size']) { $hfsz = $h[$side][$pos]['font-size']; }
		else { $hfsz = $this->default_font_size; }
		$maxfontheight = max($maxfontheight,$hfsz);
	  }
	}
	// LEFT-CENTER-RIGHT
	foreach(array('L','C','R') AS $pos) {
	  if (isset($h[$side][$pos]['content']) && $h[$side][$pos]['content']) {
		$hd = str_replace('{PAGENO}',$pgno,$h[$side][$pos]['content']);
		$hd = str_replace($this->aliasNbPgGp,$this->nbpgPrefix.$this->aliasNbPgGp.$this->nbpgSuffix,$hd);
		$hd = preg_replace('/\{DATE\s+(.*?)\}/e',"date('\\1')",$hd);
		if (isset($h[$side][$pos]['font-family']) && $h[$side][$pos]['font-family']) { $hff = $h[$side][$pos]['font-family']; }
		else { $hff = $this->original_default_font; }
		if (isset($h[$side][$pos]['font-size']) && $h[$side][$pos]['font-size']) { $hfsz = $h[$side][$pos]['font-size']; }
		else { $hfsz = $this->original_default_font_size; }	// pts
		$maxfontheight = max($maxfontheight,$hfsz);
		$hfst = '';
		if (isset($h[$side][$pos]['font-style']) && $h[$side][$pos]['font-style']) { 
			$hfst = $h[$side][$pos]['font-style'];
		}
		if (isset($h[$side][$pos]['color']) && $h[$side][$pos]['color']) { 
			$hfcol = $h[$side][$pos]['color']; 
			$cor = $this->ConvertColor($hfcol);
			if ($cor) { $this->SetTextColor($cor['R'],$cor['G'],$cor['B']); }
		}
		else { $hfcol = ''; }
		$this->SetFont($hff,$hfst,$hfsz,true,true);
		$this->x = $headerlmargin ;
		$this->y = $this->margin_header - $yadj ;

		$hd = $this->purify_utf8_text($hd);
		if ($this->text_input_as_HTML) {
			$hd = $this->all_entities_to_utf8($hd);
		}
		// CONVERT CODEPAGE
		if ($this->usingCoreFont) { $hd = mb_convert_encoding($hd,$this->mb_enc,'UTF-8'); }
		// DIRECTIONALITY RTL
		// Font-specific ligature substitution for Indic fonts
		$align = $pos;
		if ($pos!='L' && (strpos($hd,$this->aliasNbPg)!==false || strpos($hd,$this->aliasNbPgGp)!==false)) { 
			if (strpos($hd,$this->aliasNbPgGp)!==false) { $type= 'nbpggp'; } else { $type= 'nbpg'; }
			$this->_out('{mpdfheader'.$type.' '.$pos.' ff='.$hff.' fs='.$hfst.' fz='.$hfsz.'}'); 
			$this->Cell($headerpgwidth ,$maxfontheight/$this->k ,$hd,0,0,$align,0,'',0,0,0,'M');
			$this->_out('Q');
		}
		else { 
			$this->Cell($headerpgwidth ,$maxfontheight/$this->k ,$hd,0,0,$align,0,'',0,0,0,'M');
		}
		if ($hfcol) { $this->SetTextColor(0); }
	  }
	}
	//Return Font to normal
	$this->SetFont($this->default_font,'',$this->original_default_font_size);
	// LINE
	if (isset($h[$side]['line']) && $h[$side]['line']) { 
		$this->SetLineWidth(0.1);
		$this->SetDrawColor(0);
		$this->Line($headerlmargin , $this->margin_header + ($maxfontheight*(1+$this->header_line_spacing)/$this->k) - $yadj , $headerlmargin + $headerpgwidth, $this->margin_header + ($maxfontheight*(1+$this->header_line_spacing)/$this->k) - $yadj  );
	}
	if ($this->forcePortraitHeaders && $this->CurOrientation=='L' && $this->CurOrientation!=$this->DefOrientation) {
		$this->_out('Q');
	}
  }
  $this->SetY($this->tMargin);

  $this->processingHeader=false;
}




function SetHTMLHeader($header='',$OE='',$write=false) {

	$height = 0;
	if (is_array($header) && isset($header['html']) && $header['html']) { 
		$Hhtml = $header['html']; 
		if ($this->setAutoTopMargin) {
			if (isset($header['h'])) { $height = $header['h']; }
			else { $height = $this->_gethtmlheight($Hhtml); }
		}
	}
	else if (!is_array($header) && $header) { 
		$Hhtml = $header; 
		if ($this->setAutoTopMargin) { $height = $this->_gethtmlheight($Hhtml); }
	}
	else { $Hhtml = ''; }

	if ($OE != 'E') { $OE = 'O'; }
	if ($OE == 'E') {
	   
	   if ($Hhtml) {
		$this->HTMLHeaderE['html'] = $Hhtml;
		$this->HTMLHeaderE['h'] = $height;
	   }
	   else { $this->HTMLHeaderE = ''; }
	}
	else {
	   
	   if ($Hhtml) {
		$this->HTMLHeader['html'] = $Hhtml;
		$this->HTMLHeader['h'] = $height;
	   }
	   else { $this->HTMLHeader = ''; }
	}
	if (!$this->mirrorMargins && $OE == 'E') { return; }
	if ($Hhtml=='') { return; }
	if ($OE == 'E') {
		$this->headerDetails['even'] = array();	// override and clear any other non-HTML header/footer
	}
	else {
		$this->headerDetails['odd'] = array();	// override and clear any non-HTML other header/footer
	}

	if ($this->setAutoTopMargin=='pad') {
		$this->tMargin = $this->margin_header + $height + $this->orig_tMargin;
		if (isset($this->saveHTMLHeader[$this->page][$OE]['mt'])) { $this->saveHTMLHeader[$this->page][$OE]['mt'] = $this->tMargin; }
	}
	else if ($this->setAutoTopMargin=='stretch') {
		$this->tMargin = max($this->orig_tMargin, $this->margin_header + $height + $this->autoMarginPadding);
		if (isset($this->saveHTMLHeader[$this->page][$OE]['mt'])) { $this->saveHTMLHeader[$this->page][$OE]['mt'] = $this->tMargin; }
	}
	if ($write && $this->state!=0 && (($this->mirrorMargins && $OE == 'E' && ($this->page)%2==0) || ($this->mirrorMargins && $OE != 'E' && ($this->page)%2==1) || !$this->mirrorMargins)) { $this->writeHTMLHeaders(); }
}

function SetHTMLFooter($footer='',$OE='') {

	$height = 0;
	if (is_array($footer) && isset($footer['html']) && $footer['html']) { 
		$Fhtml = $footer['html']; 
		if ($this->setAutoBottomMargin) {
			if (isset($footer['h'])) { $height = $footer['h']; }
			else { $height = $this->_gethtmlheight($Fhtml); }
		}
	}
	else if (!is_array($footer) && $footer) { 
		$Fhtml = $footer; 
		if ($this->setAutoBottomMargin) { $height = $this->_gethtmlheight($Fhtml); }
	}
	else { $Fhtml = ''; }

	if ($OE != 'E') { $OE = 'O'; }
	if ($OE == 'E') {
	   
	   if ($Fhtml) {
		$this->HTMLFooterE['html'] = $Fhtml;
		$this->HTMLFooterE['h'] = $height;
	   }
	   else { $this->HTMLFooterE = ''; }
	}
	else {
	   
	   if ($Fhtml) {
		$this->HTMLFooter['html'] = $Fhtml;
		$this->HTMLFooter['h'] = $height;
	   }
	   else { $this->HTMLFooter = ''; }
	}
	if (!$this->mirrorMargins && $OE == 'E') { return; }
	if ($Fhtml=='') { return false; }
	if ($OE == 'E') {
		$this->footerDetails['even'] = array();	// override and clear any other header/footer
	}
	else {
		$this->footerDetails['odd'] = array();	// override and clear any other header/footer
	}

	if ($this->setAutoBottomMargin=='pad') {
		$this->bMargin = $this->margin_footer + $height + $this->orig_bMargin;
		$this->PageBreakTrigger=$this->h-$this->bMargin ;
		if (isset($this->saveHTMLHeader[$this->page][$OE]['mb'])) { $this->saveHTMLHeader[$this->page][$OE]['mb'] = $this->bMargin; }
	}
	else if ($this->setAutoBottomMargin=='stretch') {
		$this->bMargin = max($this->orig_bMargin, $this->margin_footer + $height + $this->autoMarginPadding);
		$this->PageBreakTrigger=$this->h-$this->bMargin ;
		if (isset($this->saveHTMLHeader[$this->page][$OE]['mb'])) { $this->saveHTMLHeader[$this->page][$OE]['mb'] = $this->bMargin; }
	}
}


function _getHtmlHeight($html) {
		$save_state = $this->state;
		$this->state = 2;
		$this->Reset();
		$this->pageoutput[$this->page] = array();
		$save_x = $this->x;
		$save_y = $this->y;
		$this->x = $this->lMargin;
		$this->y = $this->margin_header;
		$html = str_replace('{PAGENO}',$this->pagenumPrefix.$this->docPageNum($this->page).$this->pagenumSuffix,$html);
		$html = str_replace($this->aliasNbPgGp,$this->nbpgPrefix.$this->docPageNumTotal($this->page).$this->nbpgSuffix,$html );
		$html = str_replace($this->aliasNbPg,$this->page,$html );
		$html = preg_replace('/\{DATE\s+(.*?)\}/e',"date('\\1')",$html );
		$this->HTMLheaderPageLinks = array();
		$this->HTMLheaderPageAnnots = array();	// mPDF 5.0
		$savepb = $this->pageBackgrounds;
		$this->writingHTMLheader = true;
		$this->WriteHTML($html , 4);	// parameter 4 saves output to $this->headerbuffer
		$this->writingHTMLheader = false;
		$h = ($this->y - $this->margin_header);
		$this->Reset();
		$this->pageoutput[$this->page] = array();
		$this->headerbuffer = '';
		$this->pageBackgrounds = $savepb;
		$this->x = $save_x;
		$this->y = $save_y;
		$this->state = $save_state;
		return $h;
}


// Called internally from Header
function writeHTMLHeaders() {

	if ($this->mirrorMargins && ($this->page)%2==0) { $OE = 'E'; }	// EVEN
	else { $OE = 'O'; }
	if ($OE == 'E') {
		$this->saveHTMLHeader[$this->page][$OE]['html'] = $this->HTMLHeaderE['html'] ;
	}
	else {
		$this->saveHTMLHeader[$this->page][$OE]['html'] = $this->HTMLHeader['html'] ;
	}
	if ($this->forcePortraitHeaders && $this->CurOrientation=='L' && $this->CurOrientation!=$this->DefOrientation) {
		$this->saveHTMLHeader[$this->page][$OE]['rotate'] = true;
		$this->saveHTMLHeader[$this->page][$OE]['ml'] = $this->tMargin;
		$this->saveHTMLHeader[$this->page][$OE]['mr'] = $this->bMargin;
		$this->saveHTMLHeader[$this->page][$OE]['mh'] = $this->margin_header;
		$this->saveHTMLHeader[$this->page][$OE]['mf'] = $this->margin_footer;
		$this->saveHTMLHeader[$this->page][$OE]['pw'] = $this->h;
		$this->saveHTMLHeader[$this->page][$OE]['ph'] = $this->w;
	}
	else {
		$this->saveHTMLHeader[$this->page][$OE]['ml'] = $this->lMargin;
		$this->saveHTMLHeader[$this->page][$OE]['mr'] = $this->rMargin;
		$this->saveHTMLHeader[$this->page][$OE]['mh'] = $this->margin_header;
		$this->saveHTMLHeader[$this->page][$OE]['mf'] = $this->margin_footer;
		$this->saveHTMLHeader[$this->page][$OE]['pw'] = $this->w;
		$this->saveHTMLHeader[$this->page][$OE]['ph'] = $this->h;
	}
}

function writeHTMLFooters() {

	if ($this->mirrorMargins && ($this->page)%2==0) { $OE = 'E'; }	// EVEN
	else { $OE = 'O'; }
	if ($OE == 'E') {
		$this->saveHTMLFooter[$this->page][$OE]['html'] = $this->HTMLFooterE['html'] ;
	}
	else {
		$this->saveHTMLFooter[$this->page][$OE]['html'] = $this->HTMLFooter['html'] ;
	}
	if ($this->forcePortraitHeaders && $this->CurOrientation=='L' && $this->CurOrientation!=$this->DefOrientation) {
		$this->saveHTMLFooter[$this->page][$OE]['rotate'] = true;
		$this->saveHTMLFooter[$this->page][$OE]['ml'] = $this->tMargin;
		$this->saveHTMLFooter[$this->page][$OE]['mr'] = $this->bMargin;
		$this->saveHTMLFooter[$this->page][$OE]['mt'] = $this->rMargin;
		$this->saveHTMLFooter[$this->page][$OE]['mb'] = $this->lMargin;
		$this->saveHTMLFooter[$this->page][$OE]['mh'] = $this->margin_header;
		$this->saveHTMLFooter[$this->page][$OE]['mf'] = $this->margin_footer;
		$this->saveHTMLFooter[$this->page][$OE]['pw'] = $this->h;
		$this->saveHTMLFooter[$this->page][$OE]['ph'] = $this->w;
	}
	else {
		$this->saveHTMLFooter[$this->page][$OE]['ml'] = $this->lMargin;
		$this->saveHTMLFooter[$this->page][$OE]['mr'] = $this->rMargin;
		$this->saveHTMLFooter[$this->page][$OE]['mt'] = $this->tMargin;
		$this->saveHTMLFooter[$this->page][$OE]['mb'] = $this->bMargin;
		$this->saveHTMLFooter[$this->page][$OE]['mh'] = $this->margin_header;
		$this->saveHTMLFooter[$this->page][$OE]['mf'] = $this->margin_footer;
		$this->saveHTMLFooter[$this->page][$OE]['pw'] = $this->w;
		$this->saveHTMLFooter[$this->page][$OE]['ph'] = $this->h;
	}
}

function DefHeaderByName($name,$arr) {
	if (!$name) { $name = '_default'; }
	$this->pageheaders[$name] = $arr;
}

function DefFooterByName($name,$arr) {
	if (!$name) { $name = '_default'; }
	$this->pagefooters[$name] = $arr;
}

function SetHeaderByName($name,$side='O',$write=false) {
	if (!$name) { $name = '_default'; }
	if ($side=='E') { $this->headerDetails['even'] = $this->pageheaders[$name]; }
	else { $this->headerDetails['odd'] = $this->pageheaders[$name]; }
	if ($write) { $this->Header(); }
}

function SetFooterByName($name,$side='O') {
	if (!$name) { $name = '_default'; }
	if ($side=='E') { $this->footerDetails['even'] = $this->pagefooters[$name]; }
	else { $this->footerDetails['odd'] = $this->pagefooters[$name]; }
}

function DefHTMLHeaderByName($name,$html) {
	if (!$name) { $name = '_default'; }

	$this->pageHTMLheaders[$name]['html'] = $html;
	$this->pageHTMLheaders[$name]['h'] = $this->_gethtmlheight($html);
}

function DefHTMLFooterByName($name,$html) {
	if (!$name) { $name = '_default'; }

	$this->pageHTMLfooters[$name]['html'] = $html;
	$this->pageHTMLfooters[$name]['h'] = $this->_gethtmlheight($html);
}

function SetHTMLHeaderByName($name,$side='O',$write=false) {
	if (!$name) { $name = '_default'; }
	$this->SetHTMLHeader($this->pageHTMLheaders[$name],$side,$write);
}

function SetHTMLFooterByName($name,$side='O') {
	if (!$name) { $name = '_default'; }
	$this->SetHTMLFooter($this->pageHTMLfooters[$name],$side,$write);
}


function SetHeader($Harray=array(),$side='',$write=false) {
  if (is_string($Harray)) {
    if (strlen($Harray)==0) {
	if ($side=='O') { $this->headerDetails['odd'] = array(); }
	else if ($side=='E') { $this->headerDetails['even'] = array(); }
	else { $this->headerDetails = array(); }
   }
   else if (strpos($Harray,'|') || strpos($Harray,'|')===0) {
	$hdet = explode('|',$Harray);
	$this->headerDetails = array (
  		'odd' => array (
	'L' => array ('content' => $hdet[0], 'font-size' => $this->defaultheaderfontsize, 'font-style' => $this->defaultheaderfontstyle),
	'C' => array ('content' => $hdet[1], 'font-size' => $this->defaultheaderfontsize, 'font-style' => $this->defaultheaderfontstyle),
	'R' => array ('content' => $hdet[2], 'font-size' => $this->defaultheaderfontsize, 'font-style' => $this->defaultheaderfontstyle),
	'line' => $this->defaultheaderline,
  		),
  		'even' => array (
	'R' => array ('content' => $hdet[0], 'font-size' => $this->defaultheaderfontsize, 'font-style' => $this->defaultheaderfontstyle),
	'C' => array ('content' => $hdet[1], 'font-size' => $this->defaultheaderfontsize, 'font-style' => $this->defaultheaderfontstyle),
	'L' => array ('content' => $hdet[2], 'font-size' => $this->defaultheaderfontsize, 'font-style' => $this->defaultheaderfontstyle),
	'line' => $this->defaultheaderline,
		)
	);
    }
    else {
	$this->headerDetails = array (
  		'odd' => array (
	'R' => array ('content' => $Harray, 'font-size' => $this->defaultheaderfontsize, 'font-style' => $this->defaultheaderfontstyle),
	'line' => $this->defaultheaderline,
  		),
  		'even' => array (
	'L' => array ('content' => $Harray, 'font-size' => $this->defaultheaderfontsize, 'font-style' => $this->defaultheaderfontstyle),
	'line' => $this->defaultheaderline,
		)
	);
    }
  }
  else if (is_array($Harray)) {
	if ($side=='O') { $this->headerDetails['odd'] = $Harray; }
	else if ($side=='E') { $this->headerDetails['even'] = $Harray; }
	else { $this->headerDetails = $Harray; }
  }
  // Overwrite any HTML Header previously set
  if ($side=='E') { $this->SetHTMLHeader('','E'); }
  else if ($side=='O') {  $this->SetHTMLHeader(''); }
  else {
	$this->SetHTMLHeader('');
	$this->SetHTMLHeader('','E');
  }

  if ($write) { 
	$save_y = $this->y;
	$this->Header();
	$this->SetY($save_y) ; 
  }
}

function SetFooter($Farray=array(),$side='') {
  if (is_string($Farray)) {
    if (strlen($Farray)==0) {
	if ($side=='O') { $this->footerDetails['odd'] = array(); }
	else if ($side=='E') { $this->footerDetails['even'] = array(); }
	else { $this->footerDetails = array(); }
    }
    else if (strpos($Farray,'|') || strpos($Farray,'|')===0) {
	$fdet = explode('|',$Farray);
	$this->footerDetails = array (
		'odd' => array (
	'L' => array ('content' => $fdet[0], 'font-size' => $this->defaultfooterfontsize, 'font-style' => $this->defaultfooterfontstyle),
	'C' => array ('content' => $fdet[1], 'font-size' => $this->defaultfooterfontsize, 'font-style' => $this->defaultfooterfontstyle),
	'R' => array ('content' => $fdet[2], 'font-size' => $this->defaultfooterfontsize, 'font-style' => $this->defaultfooterfontstyle),
	'line' => $this->defaultfooterline,
		),
		'even' => array (
	'R' => array ('content' => $fdet[0], 'font-size' => $this->defaultfooterfontsize, 'font-style' => $this->defaultfooterfontstyle),
	'C' => array ('content' => $fdet[1], 'font-size' => $this->defaultfooterfontsize, 'font-style' => $this->defaultfooterfontstyle),
	'L' => array ('content' => $fdet[2], 'font-size' => $this->defaultfooterfontsize, 'font-style' => $this->defaultfooterfontstyle),
	'line' => $this->defaultfooterline,
		)
	);
    }
    else {
	$this->footerDetails = array (
		'odd' => array (
	'R' => array ('content' => $Farray, 'font-size' => $this->defaultfooterfontsize, 'font-style' => $this->defaultfooterfontstyle),
	'line' => $this->defaultfooterline,
		),
		'even' => array (
	'L' => array ('content' => $Farray, 'font-size' => $this->defaultfooterfontsize, 'font-style' => $this->defaultfooterfontstyle),
	'line' => $this->defaultfooterline,
		)
	);
    }
  }
  else if (is_array($Farray)) {
	if ($side=='O') { $this->footerDetails['odd'] = $Farray; }
	else if ($side=='E') { $this->footerDetails['even'] = $Farray; }
	else { $this->footerDetails = $Farray; }
  }
  // Overwrite any HTML Footer previously set
  if ($side=='E') { $this->SetHTMLFooter('','E'); }
  else if ($side=='O') {  $this->SetHTMLFooter(''); }
  else {
	$this->SetHTMLFooter('');
	$this->SetHTMLFooter('','E');
  }
}



//Page footer
function Footer() {



  if (($this->mirrorMargins && ($this->page%2==0) && $this->HTMLFooterE) || ($this->mirrorMargins && ($this->page%2==1) && $this->HTMLFooter) || (!$this->mirrorMargins && $this->HTMLFooter)) {
	$this->writeHTMLFooters(); 
	return;
  }

  $this->processingHeader=true;
  $this->ResetMargins();	// necessary after columns
  $this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
  $h = $this->footerDetails;
  if(count($h)) {

	if ($this->forcePortraitHeaders && $this->CurOrientation=='L' && $this->CurOrientation!=$this->DefOrientation) {
		$this->_out(sprintf('q 0 -1 1 0 0 %.3f cm ',($this->h*$this->k)));
		$headerpgwidth = $this->h - $this->orig_lMargin - $this->orig_rMargin;
		if (($this->mirrorMargins) && (($this->page)%2==0)) {	// EVEN
			$headerlmargin = $this->orig_rMargin;
		}
		else {
			$headerlmargin = $this->orig_lMargin;
		}
	}
	else { 
		$yadj = 0; 
		$headerpgwidth = $this->pgwidth;
		$headerlmargin = $this->lMargin;
	}
	$this->SetY(-$this->margin_footer);

	$this->SetTextColor(0);
    	$this->SUP = false;
	$this->SUB = false;
	$this->bullet = false;

	// only show pagenumber if numbering on
	$pgno = $this->docPageNum($this->page, true); 

	if (($this->mirrorMargins) && (($this->page)%2==0)) {	// EVEN
			$side = 'even';
	}
	else {	// ODD	// OR NOT MIRRORING MARGINS/FOOTERS = DEFAULT
			$side = 'odd';
	}
	$maxfontheight = 0;
	foreach(array('L','C','R') AS $pos) {
	  if (isset($h[$side][$pos]['content']) && $h[$side][$pos]['content']) {
		if (isset($h[$side][$pos]['font-size']) && $h[$side][$pos]['font-size']) { $hfsz = $h[$side][$pos]['font-size']; }
		else { $hfsz = $this->default_font_size; }
		$maxfontheight = max($maxfontheight,$hfsz);
	  }
	}
	// LEFT-CENTER-RIGHT
	foreach(array('L','C','R') AS $pos) {
	  if (isset($h[$side][$pos]['content']) && $h[$side][$pos]['content']) {
		$hd = str_replace('{PAGENO}',$pgno,$h[$side][$pos]['content']);
		$hd = str_replace($this->aliasNbPgGp,$this->nbpgPrefix.$this->aliasNbPgGp.$this->nbpgSuffix,$hd);
		$hd = preg_replace('/\{DATE\s+(.*?)\}/e',"date('\\1')",$hd);
		if (isset($h[$side][$pos]['font-family']) && $h[$side][$pos]['font-family']) { $hff = $h[$side][$pos]['font-family']; }
		else { $hff = $this->original_default_font; }
		if (isset($h[$side][$pos]['font-size']) && $h[$side][$pos]['font-size']) { $hfsz = $h[$side][$pos]['font-size']; }
		else { $hfsz = $this->original_default_font_size; }
		$maxfontheight = max($maxfontheight,$hfsz);
		if (isset($h[$side][$pos]['font-style']) && $h[$side][$pos]['font-style']) { $hfst = $h[$side][$pos]['font-style']; }
		else { $hfst = ''; }
		if (isset($h[$side][$pos]['color']) && $h[$side][$pos]['color']) { 
			$hfcol = $h[$side][$pos]['color']; 
			$cor = $this->ConvertColor($hfcol);
			if ($cor) { $this->SetTextColor($cor['R'],$cor['G'],$cor['B']); }
		}
		else { $hfcol = ''; }
		$this->SetFont($hff,$hfst,$hfsz,true,true);
		$this->x = $headerlmargin ;
//		$this->y = $this->h - $this->margin_footer - ($maxfontheight/$this->k * 0.5) - 0.5;
		$this->y = $this->h - $this->margin_footer - ($maxfontheight/$this->k);
		$hd = $this->purify_utf8_text($hd);
		if ($this->text_input_as_HTML) {
			$hd = $this->all_entities_to_utf8($hd);
		}
		// CONVERT CODEPAGE
		if ($this->usingCoreFont) { $hd = mb_convert_encoding($hd,$this->mb_enc,'UTF-8'); }
		// DIRECTIONALITY RTL
		// Font-specific ligature substitution for Indic fonts
		$align = $pos;
		if ($this->directionality == 'rtl') { 
			if ($pos == 'L') { $align = 'R'; }
			else if ($pos == 'R') { $align = 'L'; }
		}

		if ($pos!='L' && (strpos($hd,$this->aliasNbPg)!==false || strpos($hd,$this->aliasNbPgGp)!==false)) { 
			if (strpos($hd,$this->aliasNbPgGp)!==false) { $type= 'nbpggp'; } else { $type= 'nbpg'; }
			$this->_out('{mpdfheader'.$type.' '.$pos.' ff='.$hff.' fs='.$hfst.' fz='.$hfsz.'}'); 
			$this->Cell($headerpgwidth ,$maxfontheight/$this->k ,$hd,0,0,$align,0,'',0,0,0,'M');
			$this->_out('Q');
		}
		else { 
			$this->Cell($headerpgwidth ,$maxfontheight/$this->k ,$hd,0,0,$align,0,'',0,0,0,'M');
		}
		if ($hfcol) { $this->SetTextColor(0); }
	  }
	}
	// Return Font to normal
	$this->SetFont($this->default_font,'',$this->original_default_font_size);

	// LINE

	if (isset($h[$side]['line']) && $h[$side]['line']) { 
		$this->SetLineWidth(0.1);
		$this->SetDrawColor(0);
		$this->Line($headerlmargin , $this->y-($maxfontheight*($this->footer_line_spacing)/$this->k), $headerlmargin +$headerpgwidth, $this->y-($maxfontheight*($this->footer_line_spacing)/$this->k));
	}
	if ($this->forcePortraitHeaders && $this->CurOrientation=='L' && $this->CurOrientation!=$this->DefOrientation) {
		$this->_out('Q');
	}
  }
  $this->processingHeader=false;

}




///////////////////
/// HTML parser ///
///////////////////
function WriteHTML($html,$sub=0,$init=true,$close=true) {
				// $sub ADDED - 0 = default; 1=headerCSS only; 2=HTML body (parts) only; 3 - HTML parses only
				// 4 - writes HTML headers
				// $close Leaves buffers etc. in current state, so that it can continue a block etc.
				// $init - Clears and sets buffers to Top level block etc.

	if (empty($html)) { $html = ''; }
	if ($this->progressBar) { $this->UpdateProgressBar(1,0,'Parsing CSS & Headers'); }

	if ($init) {
		$this->headerbuffer='';
		$this->textbuffer = array();
		$this->fixedPosBlockSave = array();
	}

	if ($sub == 1) { $html = '<style> '.$html.' </style>'; }	// stylesheet only

	if ($this->allow_charset_conversion) {
		if ($sub < 1) { 
			$this->ReadCharset($html); 
		}
		if ($this->charset_in) { 
			$success = iconv($this->charset_in,'UTF-8//TRANSLIT',$html); 
			if ($success) { $html = $success; }
		}
	}

	$html = $this->purify_utf8($html,false);
	if ($init) {
		$this->blklvl = 0;
		$this->lastblocklevelchange = 0;
		$this->blk = array();
		$this->initialiseBlock($this->blk[0]);
		$this->blk[0]['width'] =& $this->pgwidth;
		$this->blk[0]['inner_width'] =& $this->pgwidth;
		$this->blk[0]['blockContext'] = $this->blockContext;
	}

	$zproperties = array();
	if ($sub < 2) { 
		$this->ReadMetaTags($html); 

		// NB default stylesheet now in mPDF.css - read on initialising class
		$html = $this->ReadCSS($html); 

		if ($this->useLang && !$this->usingCoreFont && preg_match('/<html [^>]*lang=[\'\"](.*?)[\'\"]/ism',$html,$m)) { 
			$html_lang = $m[1]; 
		}

		// mPDDF 5.0
		if ($this->useLang && !$this->usingCoreFont && preg_match('/<html [^>]*dir=[\'\"]\s*rtl\s*[\'\"]/ism',$html)) { 
			$zproperties['DIR'] = 'rtl'; 
		}

		// allow in-line CSS for body tag to be parsed // Get <body> tag inline CSS
		if (preg_match('/<body([^>]*)>(.*?)<\/body>/ism',$html,$m) || preg_match('/<body([^>]*)>(.*)$/ism',$html,$m)) { 
			$html = $m[2]; 
			// Changed to allow style="background: url('bg.jpg')"
			if (preg_match('/style=[\"](.*?)[\"]/ism',$m[1],$mm) || preg_match('/style=[\'](.*?)[\']/ism',$m[1],$mm)) { 
				$zproperties = $this->readInlineCSS($mm[1]); 
			}
			// mPDF 5.0
			if (preg_match('/dir=[\'\"]\s*rtl\s*[\'\"]/ism',$m[1])) { 
				$zproperties['DIR'] = 'rtl'; 
			}
			if (isset($html_lang) && $html_lang) { $properties['LANG'] = $html_lang; }
			if ($this->useLang && !$this->usingCoreFont && preg_match('/lang=[\'\"](.*?)[\'\"]/ism',$m[1],$mm)) { 
				$zproperties['LANG'] = $mm[1]; 
			}

		}
		if ($zproperties['DIR'] == 'rtl' || $zproperties['DIRECTION'] == 'rtl') { $this->directionality = 'rtl'; }
	}

	$properties = $this->MergeCSS('BLOCK','BODY','');
	if ($zproperties) { $properties = $this->array_merge_recursive_unique($properties,$zproperties); }
	$this->setCSS($properties,'','BODY'); 

	$this->blk[0]['InlineProperties'] = $this->saveInlineProperties();	// mPDF 5.0

	if ($sub == 1) { return ''; }

	if (!isset($this->CSS['BODY'])) { $this->CSS['BODY'] = array(); }



	if($this->state==0 && $sub!=1 && $sub!=3 && $sub!=4) {
		$this->AddPage($this->CurOrientation);
	}

	$parseonly = false; 
	$this->bufferoutput = false; 
	if ($sub == 3) { 
		$parseonly = true; 
		// Close any open block tags
		for ($b= $this->blklvl;$b>0;$b--) { $this->CloseTag($this->blk[$b]['tag']); }
		// Output any text left in buffer
		if (count($this->textbuffer)) { $this->printbuffer($this->textbuffer); }
		$this->textbuffer=array();
	} 
	else if ($sub == 4) { 
		// Close any open block tags
		for ($b= $this->blklvl;$b>0;$b--) { $this->CloseTag($this->blk[$b]['tag']); }
		// Output any text left in buffer
		if (count($this->textbuffer)) { $this->printbuffer($this->textbuffer); }
		$this->bufferoutput = true; 
		$this->textbuffer=array();
		$this->headerbuffer='';
		$properties = $this->MergeCSS('BLOCK','BODY','');
		$this->setCSS($properties,'','BODY'); 
	} 

	mb_internal_encoding('UTF-8'); 

	$html = $this->AdjustHTML($html,$this->directionality,$this->usepre, $this->tabSpaces); //Try to make HTML look more like XHTML

	if ($this->autoFontGroups) { $html = $this->AutoFont($html); }

	preg_match_all('/<htmlpageheader([^>]*)>(.*?)<\/htmlpageheader>/si',$html,$h);
	for($i=0;$i<count($h[1]);$i++) {
		if (preg_match('/name=[\'|\"](.*?)[\'|\"]/',$h[1][$i],$n)) {
			$this->pageHTMLheaders[$n[1]]['html'] = $h[2][$i]; 
			$this->pageHTMLheaders[$n[1]]['h'] = $this->_gethtmlheight($h[2][$i]); 
		}
	}
	preg_match_all('/<htmlpagefooter([^>]*)>(.*?)<\/htmlpagefooter>/si',$html,$f);
	for($i=0;$i<count($f[1]);$i++) {
		if (preg_match('/name=[\'|\"](.*?)[\'|\"]/',$f[1][$i],$n)) {
			$this->pageHTMLfooters[$n[1]]['html'] = $f[2][$i]; 
			$this->pageHTMLfooters[$n[1]]['h'] = $this->_gethtmlheight($f[2][$i]); 
		}
	}
	$html = preg_replace('/<htmlpageheader.*?<\/htmlpageheader>/si','',$html);
	$html = preg_replace('/<htmlpagefooter.*?<\/htmlpagefooter>/si','',$html);



	if (isset($hname) && preg_match('/^html_(.*)$/i',$hname,$n)) $this->SetHTMLHeader($this->pageHTMLheaders[$n[1]],'O',true);
	if (isset($fname) && preg_match('/^html_(.*)$/i',$fname,$n)) $this->SetHTMLFooter($this->pageHTMLfooters[$n[1]],'O');


	$html=str_replace('<?','< ',$html); //Fix '<?XML' bug from HTML code generated by MS Word
	if ($this->onlyCoreFonts) { $html = $this->SubstituteChars($html); }


	// mPDF 5.0
	if (preg_match("/([\x{20000}-\x{2FFFF}])/u", $html)) { $this->checkSIP = true; }
	else { $this->checkSIP = false; }

	// mPDF 5.0.03
	if (preg_match("/([\x{10000}-\x{1FFFF}])/u", $html)) { $this->checkSMP = true; }
	else { $this->checkSMP = false; }

	// mPDF 5.0
	if (preg_match("/([".$this->pregCJKchars."])/u", $html)) { $this->checkCJK = true; }
	else { $this->checkCJK = false; }

	// Don't allow non-breaking spaces that are converted to substituted chars or will break anyway and mess up table width calc.
	$html = str_replace('<tta>160</tta>',$this->chrs[32],$html); 
	$html = str_replace('</tta><tta>','|',$html); 
	$html = str_replace('</tts><tts>','|',$html); 
	$html = str_replace('</ttz><ttz>','|',$html); 

	//Add new supported tags in the DisableTags function
	$html=strip_tags($html,$this->enabledtags); //remove all unsupported tags, but the ones inside the 'enabledtags' string

	//Explode the string in order to parse the HTML code
	$a=preg_split('/<(.*?)>/ms',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	// ? more accurate regexp that allows e.g. <a name="Silly <name>">
	// if changing - also change in fn.SubstituteChars()
	// $a = preg_split ('/<((?:[^<>]+(?:"[^"]*"|\'[^\']*\')?)+)>/ms', $html, -1, PREG_SPLIT_DELIM_CAPTURE);

	if ($this->mb_enc) { 
		mb_internal_encoding($this->mb_enc); 
	}
	$pbc = 0;
	if ($this->progressBar) { $this->UpdateProgressBar(1,0); }
	$this->subPos = 0;
	$cnt = count($a);
	for($i=0;$i<$cnt; $i++) {
		$e = $a[$i];
		if($i%2==0) {
		//TEXT
			if ($this->blk[$this->blklvl]['hide']) { continue; }
			if ($this->inlineDisplayOff) { continue; }	// mPDF 5.0

			if (strlen($e) == 0) { continue; }

			$e = strcode2utf($e);
			$e = $this->lesser_entity_decode($e);

			// mPDF 5.0
			if ($this->checkSIP && $this->CurrentFont['sipext'] && !$this->usingCoreFont && $this->subPos<$i && !$this->specialcontent) { 
				$cnt += $this->SubstituteCharsSIP($a, $i, $e); 
			}

			// mPDF 5.0
			if ($this->useSubstitutions && !$this->onlyCoreFonts && !$this->usingCoreFont && $this->CurrentFont['type']!='Type0' && $this->subPos<$i && !$this->specialcontent) { 
				$cnt += $this->SubstituteCharsMB($a, $i, $e); 
			}


			// Font-specific ligature substitution for Indic fonts

			// CONVERT ENCODING
			if ($this->usingCoreFont) { 
				$e = mb_convert_encoding($e,$this->mb_enc,'UTF-8'); 
				if ($this->toupper) { $e = strtoupper($e); }
				if ($this->tolower) { $e = strtolower($e); }
			}
			else {
				if ($this->toupper) { $e = mb_strtoupper($e,$this->mb_enc); }
				if ($this->tolower) { $e = mb_strtolower($e,$this->mb_enc); }
			}
			if (($this->tts) || ($this->ttz) || ($this->tta)) {
				$es = explode('|',$e);
				$e = '';
				foreach($es AS $val) {
					$e .= $this->chrs[$val];
				}
			}
			//Adjust lineheight
      		//$this->SetLineHeight($this->FontSizePt); //should be inside printbuffer? // does nothing


			// TABLE
			// ALL ELSE
			else {
    				if ($this->ignorefollowingspaces and !$this->ispre) { $e = ltrim($e); }
				if ($e || $e==='0') $this->textbuffer[] = array($e,$this->HREF,$this->currentfontstyle,$this->colorarray,$this->currentfontfamily,$this->SUP,$this->SUB,'',$this->strike,$this->outlineparam,$this->spanbgcolorarray,$this->currentfontsize,$this->ReqFontStyle); 
			}
		}


		else { // TAG **
		   
		   if($e[0]=='/') {

			if ($this->progressBar) { 	// 10% increments
				if (intval($i*10/$cnt) != $pbc) { $pbc = intval($i*10/$cnt); $this->UpdateProgressBar(1,$pbc*10,$tag); }
			}


		    // Check for tags where HTML specifies optional end tags,
    		    // and/or does not allow nesting e.g. P inside P, or 
		    $endtag = strtoupper(substr($e,1));
		    if($this->blk[$this->blklvl]['hide']) { 
			if (in_array($endtag, $this->outerblocktags) || in_array($endtag, $this->innerblocktags)) { 
				unset($this->blk[$this->blklvl]);
				$this->blklvl--; 
			}
			continue; 
		    }

		    if ($this->allow_html_optional_endtags && !$parseonly) {
			if (($endtag == 'DIV' || $endtag =='FORM' || $endtag =='CENTER') && $this->lastoptionaltag == 'P') { $this->CloseTag($this->lastoptionaltag ); }
			if ($this->lastoptionaltag == 'LI' && $endtag == 'OL') { $this->CloseTag($this->lastoptionaltag ); }
			if ($this->lastoptionaltag == 'LI' && $endtag == 'UL') { $this->CloseTag($this->lastoptionaltag ); }
			if ($this->lastoptionaltag == 'DD' && $endtag == 'DL') { $this->CloseTag($this->lastoptionaltag ); }
			if ($this->lastoptionaltag == 'DT' && $endtag == 'DL') { $this->CloseTag($this->lastoptionaltag ); }
			if ($this->lastoptionaltag == 'OPTION' && $endtag == 'SELECT') { $this->CloseTag($this->lastoptionaltag ); }
		    }
		    $this->CloseTag($endtag); 
		   }

		   else {	// OPENING TAG
			if($this->blk[$this->blklvl]['hide']) { 
				if (strpos($e,' ')) { $te = strtoupper(substr($e,0,strpos($e,' '))); }
				else { $te = strtoupper($e); } 
				if (in_array($te, $this->outerblocktags) || in_array($te, $this->innerblocktags)) { 
					$this->blklvl++;
 					$this->blk[$this->blklvl]['hide']=true;
				}
				continue; 
			}

			$regexp = '|=\'(.*?)\'|s'; // eliminate single quotes, if any
      		$e = preg_replace($regexp,"=\"\$1\"",$e);
			// changes anykey=anyvalue to anykey="anyvalue" (only do this inside tags)
			if (substr($e,0,10)!='pageheader' && substr($e,0,10)!='pagefooter') {
				$regexp = '| (\\w+?)=([^\\s>"]+)|si'; 
	      		$e = preg_replace($regexp," \$1=\"\$2\"",$e);
			}

      		$e = preg_replace('/ (\\S+?)\s*=\s*"/i', " \\1=\"", $e);	// mPDF 5.0

      		//Fix path values, if needed
			$orig_srcpath = '';
			if ((stristr($e,"href=") !== false) or (stristr($e,"src=") !== false) ) {
				$regexp = '/ (href|src)\s*=\s*"(.*?)"/i';
				preg_match($regexp,$e,$auxiliararray);
				if (isset($auxiliararray[2])) { $path = $auxiliararray[2]; }
				else { $path = ''; }
				if (trim($path) != '' && !(stristr($e,"src=") !== false && substr($path,0,4)=='var:')) { 
					$orig_srcpath = $path;
					$this->GetFullPath($path); 
					$regexp = '/ (href|src)="(.*?)"/i';
					$e = preg_replace($regexp,' \\1="'.$path.'"',$e);
				}
			}//END of Fix path values


			//Extract attributes
			$contents=array();
			// Changed to allow style="background: url('bg.jpg')"
			preg_match_all('/\\S*=["][^"]*["]/',$e,$contents1);
			preg_match_all('/\\S*=[\'][^\']*[\']/',$e,$contents2);
			$contents = array_merge($contents1, $contents2);
			preg_match('/\\S+/',$e,$a2);
			$tag=strtoupper($a2[0]);
			$attr=array();
			if ($orig_srcpath) { $attr['ORIG_SRC'] = $orig_srcpath; }
			if (!empty($contents)) {
				foreach($contents[0] as $v) {
					// Changed to allow style="background: url('bg.jpg')"
 					if(preg_match('/^([^=]*)=["]?([^"]*)["]?$/',$v,$a3) || preg_match('/^([^=]*)=[\']?([^\']*)[\']?$/',$v,$a3)) {
 						if (strtoupper($a3[1])=='ID' || strtoupper($a3[1])=='CLASS') {	// 4.2.013 Omits STYLE
   							$attr[strtoupper($a3[1])]=trim(strtoupper($a3[2]));
						}
						// includes header-style-right etc. used for <pageheader>
 						else if (preg_match('/^(HEADER|FOOTER)-STYLE/i',$a3[1])) {
   							$attr[strtoupper($a3[1])]=trim(strtoupper($a3[2]));
						}
						else {
    							$attr[strtoupper($a3[1])]=trim($a3[2]);
						}
     					}
  				}
			}
			$this->OpenTag($tag,$attr);
		   }

		} // end TAG
	} //end of	foreach($a as $i=>$e)

	if ($close) {

		// Close any open block tags
		for ($b= $this->blklvl;$b>0;$b--) { $this->CloseTag($this->blk[$b]['tag']); }

		// Output any text left in buffer
		if (count($this->textbuffer) && !$parseonly) { $this->printbuffer($this->textbuffer); }
		if (!$parseonly) $this->textbuffer=array();



		//Create Internal Links, if needed
		if (!empty($this->internallink) ) {
			foreach($this->internallink as $k=>$v) {
				if (strpos($k,"#") !== false ) { continue; } //ignore
				$ypos = $v['Y'];
				$pagenum = $v['PAGE'];
				$sharp = "#";
				while (array_key_exists($sharp.$k,$this->internallink)) {
					$internallink = $this->internallink[$sharp.$k];
					$this->SetLink($internallink,$ypos,$pagenum);
					$sharp .= "#";
				}
			}
		}

		$this->linemaxfontsize = '';
		$this->lineheight_correction = $this->default_lineheight_correction;

		$this->bufferoutput = false; 


	}
}




function initialiseBlock(&$blk) {
	$blk['margin_top'] = 0;
	$blk['margin_left'] = 0;
	$blk['margin_bottom'] = 0;
	$blk['margin_right'] = 0;
	$blk['padding_top'] = 0;
	$blk['padding_left'] = 0;
	$blk['padding_bottom'] = 0;
	$blk['padding_right'] = 0;
	$blk['border_top']['w'] = 0;
	$blk['border_left']['w'] = 0;
	$blk['border_bottom']['w'] = 0;
	$blk['border_right']['w'] = 0;
	$blk['hide'] = false; 
	$blk['outer_left_margin'] = 0; 
	$blk['outer_right_margin'] = 0; 
	$blk['cascadeCSS'] = array(); 
	$blk['block-align'] = false; 
	$blk['bgcolor'] = false; 
	$blk['page_break_after_avoid'] = false; 
	$blk['keep_block_together'] = false; 
	$blk['float'] = false; 
	$blk['line_height'] = ''; 
	$blk['margin_collapse'] = false; 
}


function border_details($bd) {
	$prop = preg_split('/\s+/',trim($bd));

	if (isset($this->blk[$this->blklvl]['inner_width'])) { $refw = $this->blk[$this->blklvl]['inner_width']; }
	else if (isset($this->blk[$this->blklvl-1]['inner_width'])) { $refw = $this->blk[$this->blklvl-1]['inner_width']; }
	else { $refw = $this->w; }
	if ( count($prop) == 1 ) { 
		$bsize = $this->ConvertSize($prop[0],$refw,$this->FontSize,false);
		if ($bsize > 0) {
			return array('s' => 1, 'w' => $bsize, 'c' => array('R'=>0,'G'=>0,'B'=>0), 'style'=>'solid');
		}
		else { return array('w' => 0, 's' => 0); }
	}

	else if (count($prop) == 2 ) { 
		// 1px solid 
		if (in_array($prop[1],$this->borderstyles) || $prop[1] == 'none' || $prop[1] == 'hidden' ) { $prop[2] = ''; }
		// solid #000000 
		else if (in_array($prop[0],$this->borderstyles) || $prop[0] == 'none' || $prop[0] == 'hidden' ) { $prop[0] = ''; $prop[1] = $prop[0]; $prop[2] = $prop[1]; }
		// 1px #000000 
		else { $prop[1] = ''; $prop[2] = $prop[1]; }
	}
	else if ( count($prop) == 3 ) {
		// Change #000000 1px solid to 1px solid #000000 (proper)
		if (substr($prop[0],0,1) == '#') { $tmp = $prop[0]; $prop[0] = $prop[1]; $prop[1] = $prop[2]; $prop[2] = $tmp; }
		// Change solid #000000 1px to 1px solid #000000 (proper)
		else if (substr($prop[0],1,1) == '#') { $tmp = $prop[1]; $prop[0] = $prop[2]; $prop[1] = $prop[0]; $prop[2] = $tmp; }
		// Change solid 1px #000000 to 1px solid #000000 (proper)
		else if (in_array($prop[0],$this->borderstyles) || $prop[0] == 'none' || $prop[0] == 'hidden' ) { 
			$tmp = $prop[0]; $prop[0] = $prop[1]; $prop[1] = $tmp; 
		}
	}
	else { return array(); } 
	// Size
	$bsize = $this->ConvertSize($prop[0],$refw,$this->FontSize,false);
	//color
	$coul = $this->ConvertColor($prop[2]);	// returns array
	// Style
	$prop[1] = strtolower($prop[1]);
	if (in_array($prop[1],$this->borderstyles) && $bsize > 0) { $on = 1; } 
	else if ($prop[1] == 'hidden') { $on = 1; $bsize = 0; $coul = ''; } 
	else if ($prop[1] == 'none') { $on = 0; $bsize = 0; $coul = ''; } 
	else { $on = 0; $bsize = 0; $coul = ''; $prop[1] = ''; }
	return array('s' => $on, 'w' => $bsize, 'c' => $coul, 'style'=> $prop[1] );
}


function _fix_borderStr($bd) {
	$prop = preg_split('/\s+/',trim($bd));
	$w = 'medium';
	$c = '#000000';
	$s = 'none';

	if ( count($prop) == 1 ) { 
		// solid
		if (in_array($prop[0],$this->borderstyles) || $prop[0] == 'none' || $prop[0] == 'hidden' ) { $s = $prop[0]; }
		// #000000
		else if (is_array($this->ConvertColor($prop[0]))) { $c = $prop[0]; }
		// 1px 
		else { $w = $prop[0]; }
	}
	else if (count($prop) == 2 ) { 
		// 1px solid 
		if (in_array($prop[1],$this->borderstyles) || $prop[1] == 'none' || $prop[1] == 'hidden' ) { $w = $prop[0]; $s = $prop[1]; }
		// solid #000000 
		else if (in_array($prop[0],$this->borderstyles) || $prop[0] == 'none' || $prop[0] == 'hidden' ) { $s = $prop[0]; $c = $prop[1]; }
		// 1px #000000 
		else { $w = $prop[0]; $c = $prop[1]; }
	}
	else if ( count($prop) == 3 ) {
		// Change #000000 1px solid to 1px solid #000000 (proper)
		if (substr($prop[0],0,1) == '#') { $c = $prop[0]; $w = $prop[1]; $s = $prop[2]; }
		// Change solid #000000 1px to 1px solid #000000 (proper)
		else if (substr($prop[0],1,1) == '#') { $s = $prop[0]; $c = $prop[1]; $w = $prop[2]; }
		// Change solid 1px #000000 to 1px solid #000000 (proper)
		else if (in_array($prop[0],$this->borderstyles) || $prop[0] == 'none' || $prop[0] == 'hidden' ) { 
			$s = $prop[0]; $w = $prop[1]; $c = $prop[2]; 
		}
		else { $w = $prop[0]; $s = $prop[1]; $c = $prop[2]; }
	}
	else { return ''; } 
	$s = strtolower($s);
	return $w.' '.$s.' '.$c;
}



// NEW FUNCTION FOR CSS MARGIN or PADDING called from SetCSS
function fixCSS($prop) {
	if (!is_array($prop) || (count($prop)==0)) return array(); 
	$newprop = array(); 
	foreach($prop AS $k => $v) {
		if ($k != 'BACKGROUND-IMAGE' && $k != 'BACKGROUND' && $k != 'ODD-HEADER-NAME' && $k != 'EVEN-HEADER-NAME' && $k != 'ODD-FOOTER-NAME' && $k != 'EVEN-FOOTER-NAME' && $k != 'HEADER' && $k != 'FOOTER') {
			$v = strtolower($v);
		}

		if ($k == 'FONT') {
			$s = trim($v);
			preg_match_all('/\"(.*?)\"/',$s,$ff);
			if (count($ff[1])) {
				foreach($ff[1] AS $ffp) { 
					$w = preg_split('/\s+/',$ffp);
					$s = preg_replace('/\"'.$ffp.'\"/',$w[0],$s); 
				}
			}
			preg_match_all('/\'(.*?)\'/',$s,$ff);
			if (count($ff[1])) {
				foreach($ff[1] AS $ffp) { 
					$w = preg_split('/\s+/',$ffp);
					$s = preg_replace('/\''.$ffp.'\'/',$w[0],$s); 
				}
			}
			$s = preg_replace('/\s*,\s*/',',',$s); 
			$bits = preg_split('/\s+/',$s);
			if (count($bits)>1) {
				$k = 'FONT-FAMILY'; $v = $bits[(count($bits)-1)];
				$fs = $bits[(count($bits)-2)];
				if (preg_match('/(.*?)\/(.*)/',$fs, $fsp)) { 
					$newprop['FONT-SIZE'] = $fsp[1];
					$newprop['LINE-HEIGHT'] = $fsp[2];
				}
				else { $newprop['FONT-SIZE'] = $fs; } 
				if (preg_match('/(italic|oblique)/i',$s)) { $newprop['FONT-STYLE'] = 'italic'; }
				else { $newprop['FONT-STYLE'] = 'normal'; }
				if (preg_match('/bold/i',$s)) { $newprop['FONT-WEIGHT'] = 'bold'; }
				else { $newprop['FONT-WEIGHT'] = 'normal'; }
				if (preg_match('/small-caps/i',$s)) { $newprop['TEXT-TRANSFORM'] = 'uppercase'; }
			}
		}
		if ($k == 'FONT-FAMILY') {
			$aux_fontlist = explode(",",$v);
			$found = 0;
			foreach($aux_fontlist AS $f) {
				$fonttype = trim($f);
				$fonttype = preg_replace('/["\']*(.*?)["\']*/','\\1',$fonttype);
				$fonttype = preg_replace('/ /','',$fonttype);
				$v = strtolower(trim($fonttype));
				if (isset($this->fonttrans[$v]) && $this->fonttrans[$v]) { $v = $this->fonttrans[$v]; }
				if ((!$this->usingCoreFont && in_array($v,$this->available_unifonts)) || 
					($this->usingCoreFont && in_array($v,array('courier','times','helvetica','arial'))) || 
					in_array($v, array('sjis','uhc','big5','gb'))) { 
					$newprop[$k] = $v; 
					$found = 1;
					break;
				}
			}
			if (!$found) {
			   foreach($aux_fontlist AS $f) {
				$fonttype = trim($f);
				$fonttype = preg_replace('/["\']*(.*?)["\']*/','\\1',$fonttype);
				$fonttype = preg_replace('/ /','',$fonttype);
				$v = strtolower(trim($fonttype));
				if (isset($this->fonttrans[$v]) && $this->fonttrans[$v]) { $v = $this->fonttrans[$v]; }
				if (in_array($v,$this->sans_fonts) || in_array($v,$this->serif_fonts) || in_array($v,$this->mono_fonts) ) { 
					$newprop[$k] = $v; 
					break;
				}
			   }
			}
		}
		else if ($k == 'MARGIN') {
			$tmp =  $this->expand24($v);
			$newprop['MARGIN-TOP'] = $tmp['T'];
			$newprop['MARGIN-RIGHT'] = $tmp['R'];
			$newprop['MARGIN-BOTTOM'] = $tmp['B'];
			$newprop['MARGIN-LEFT'] = $tmp['L'];
		}
		else if ($k == 'PADDING') {
			$tmp =  $this->expand24($v);
			$newprop['PADDING-TOP'] = $tmp['T'];
			$newprop['PADDING-RIGHT'] = $tmp['R'];
			$newprop['PADDING-BOTTOM'] = $tmp['B'];
			$newprop['PADDING-LEFT'] = $tmp['L'];
		}
		else if ($k == 'BORDER') {
			if ($v == '1') { $v = '1px solid #000000'; }
			else { $v = $this->_fix_borderStr($v); }
			$newprop['BORDER-TOP'] = $v;
			$newprop['BORDER-RIGHT'] = $v;
			$newprop['BORDER-BOTTOM'] = $v;
			$newprop['BORDER-LEFT'] = $v;
		}
		else if ($k == 'BORDER-TOP') {
			$newprop['BORDER-TOP'] = $this->_fix_borderStr($v);
		}
		else if ($k == 'BORDER-RIGHT') {
			$newprop['BORDER-RIGHT'] = $this->_fix_borderStr($v);
		}
		else if ($k == 'BORDER-BOTTOM') {
			$newprop['BORDER-BOTTOM'] = $this->_fix_borderStr($v);
		}
		else if ($k == 'BORDER-LEFT') {
			$newprop['BORDER-LEFT'] = $this->_fix_borderStr($v);
		}
		else if ($k == 'BORDER-STYLE') {
			$e = $this->expand24($v);
			$newprop['BORDER-TOP-STYLE'] = $e['T'];
			$newprop['BORDER-RIGHT-STYLE'] = $e['R'];
			$newprop['BORDER-BOTTOM-STYLE'] = $e['B'];
			$newprop['BORDER-LEFT-STYLE'] = $e['L'];
		}
		else if ($k == 'BORDER-WIDTH') {
			$e = $this->expand24($v);
			$newprop['BORDER-TOP-WIDTH'] = $e['T'];
			$newprop['BORDER-RIGHT-WIDTH'] = $e['R'];
			$newprop['BORDER-BOTTOM-WIDTH'] = $e['B'];
			$newprop['BORDER-LEFT-WIDTH'] = $e['L'];
		}
		else if ($k == 'BORDER-COLOR') {
			$e = $this->expand24($v);
			$newprop['BORDER-TOP-COLOR'] = $e['T'];
			$newprop['BORDER-RIGHT-COLOR'] = $e['R'];
			$newprop['BORDER-BOTTOM-COLOR'] = $e['B'];
			$newprop['BORDER-LEFT-COLOR'] = $e['L'];
		}

		else if ($k == 'BORDER-SPACING') {
			$prop = preg_split('/\s+/',trim($v));
			if (count($prop) == 1 ) { 
				$newprop['BORDER-SPACING-H'] = $prop[0];
				$newprop['BORDER-SPACING-V'] = $prop[0];
			}
			else if (count($prop) == 2 ) { 
				$newprop['BORDER-SPACING-H'] = $prop[0];
				$newprop['BORDER-SPACING-V'] = $prop[1];
			}
		}
		else if ($k == 'SIZE') {
			$prop = preg_split('/\s+/',trim($v));
			if (preg_match('/(auto|portrait|landscape)/',$prop[0])) {
				$newprop['SIZE'] = strtoupper($prop[0]);
			}
			else if (count($prop) == 1 ) {
				$newprop['SIZE']['W'] = $this->ConvertSize($prop[0]);
				$newprop['SIZE']['H'] = $this->ConvertSize($prop[0]);
			}
			else if (count($prop) == 2 ) {
				$newprop['SIZE']['W'] = $this->ConvertSize($prop[0]);
				$newprop['SIZE']['H'] = $this->ConvertSize($prop[1]);
			}
		}
		else if ($k == 'SHEET-SIZE') {
			$prop = preg_split('/\s+/',trim($v));
			if (count($prop) == 2 ) {
				$newprop['SHEET-SIZE'] = array($this->ConvertSize($prop[0]), $this->ConvertSize($prop[1]));
			}
			else {
				if(preg_match('/([0-9a-zA-Z]*)-L/i',$v,$m)) {	// e.g. A4-L = A$ landscape
					$ft = $this->_getPageFormat($m[1]);
					$format = array($ft[1],$ft[0]);
				}
				else { $format = $this->_getPageFormat($v); }
				if ($format) { $newprop['SHEET-SIZE'] = array($format[0]/$this->k, $format[1]/$this->k); }
			}
		}
		else if ($k == 'BACKGROUND') {
			$bg = $this->parseCSSbackground($v);
			if ($bg['c']) { $newprop['BACKGROUND-COLOR'] = $bg['c']; }
			else { $newprop['BACKGROUND-COLOR'] = 'transparent'; }
		}
		else { 
			$newprop[$k] = $v; 
		}
	}

	return $newprop;
}


function parseCSSbackground($s) {
	$bg = array('c'=>false, 'i'=>false, 'r'=>false, 'p'=>false, );
	if (preg_match('/url\(/i',$s)) {
		// If color, set and strip it off
		if (preg_match('/^\s*(#[0-9a-fA-F]{3,6}|rgb\(.*?\)|[a-zA-Z]{3,})\s+(url\(.*)/i',$s,$m)) {
			$bg['c'] = strtolower($m[1]);
			$s = $m[2];
		}
	}
	else if (preg_match('/^\s*(#[0-9a-fA-F]{3,6}|rgb\(.*?\)|[a-zA-Z]{3,})/i',$s,$m)) { $bg['c'] = strtolower($m[1]); }
	return ($bg);
}


function expand24($mp) {
	$prop = preg_split('/\s+/',trim($mp));
	if (count($prop) == 1 ) { 
		return array('T' => $prop[0], 'R' => $prop[0], 'B' => $prop[0], 'L'=> $prop[0]);
	}
	if (count($prop) == 2 ) { 
		return array('T' => $prop[0], 'R' => $prop[1], 'B' => $prop[0], 'L'=> $prop[1]);
	}

	if (count($prop) == 3 ) { 
		return array('T' => $prop[0], 'R' => $prop[1], 'B' => $prop[2], 'L'=> $prop[1]);
	}
	if (count($prop) == 4 ) { 
		return array('T' => $prop[0], 'R' => $prop[1], 'B' => $prop[2], 'L'=> $prop[3]);
	}
	return array(); 
}


// Return either a number (factor) - based on current set fontsize (if % or em) - or exact lineheight (with 'mm' after it)
function fixLineheight($v) {
	$lh = false;
	if (preg_match('/^[0-9\.,]*$/',$v) && $v >= 0) { return ($v + 0); }
	else if (strtoupper($v) == 'NORMAL') { 
		return $this->normalLineheight; 
	}
	else { 
		$tlh = $this->ConvertSize($v,$this->FontSize,$this->FontSize,true); 
		if ($tlh) { return ($tlh.'mm'); }
	}
	return $this->normalLineheight;
}





function _mergeCSS(&$p, &$t) {
	// Save Cascading CSS e.g. "div.topic p" at this block level
	if (isset($p) && $p) {
		$carry = $p;
		if ($t) { 
			$t = $this->array_merge_recursive_unique($t, $carry); 
		}
	   	else { $t = $carry; }
	}
}

// for CSS handling
function array_merge_recursive_unique($array1, $array2) {
    $arrays = func_get_args();
    $narrays = count($arrays);
    $ret = $arrays[0];
    for ($i = 1; $i < $narrays; $i ++) {
        foreach ($arrays[$i] as $key => $value) {
            if (((string) $key) === ((string) intval($key))) { // integer or string as integer key - append
                $ret[] = $value;
            }
            else { // string key - merge
                if (is_array($value) && isset($ret[$key])) {
                    $ret[$key] = $this->array_merge_recursive_unique($ret[$key], $value);
                }
                else {
                    $ret[$key] = $value;
                }
            }
        }   
    }
    return $ret;
}



function _mergeFullCSS(&$p, &$t, $tag, $classes, $id) {
		$this->_mergeCSS($p[$tag], $t);
		// STYLESHEET CLASS e.g. .smallone{}  .redletter{}
		foreach($classes AS $class) {
		  $this->_mergeCSS($p['CLASS>>'.$class], $t);
		}
		// STYLESHEET CLASS e.g. #smallone{}  #redletter{}
		if (isset($id) && $id) {
		  $this->_mergeCSS($p['ID>>'.$id], $t);
		}
		// STYLESHEET CLASS e.g. .smallone{}  .redletter{}
		foreach($classes AS $class) {
		  $this->_mergeCSS($p[$tag.'>>CLASS>>'.$class], $t);
		}
		// STYLESHEET CLASS e.g. #smallone{}  #redletter{}
		if (isset($id)) {
		  $this->_mergeCSS($p[$tag.'>>ID>>'.$id], $t);
		}
}


function _set_mergedCSS(&$m, &$p, $d=true, $bd=false) {
	if (isset($m)) {
		if ((isset($m['depth']) && $m['depth']>1) || $d==false) { 	// include check for 'depth'
			if (is_array($m)) { 
				$p = array_merge($p,$m); 
				$this->_mergeBorders($p,$m);
			}
		}
	}
}


function _mergeBorders(&$b, &$a) {	// Merges $a['BORDER-TOP-STYLE'] to $b['BORDER-TOP'] etc.
  foreach(array('TOP','RIGHT','BOTTOM','LEFT') AS $side) {
    foreach(array('STYLE','WIDTH','COLOR') AS $el) {
	if (isset($a['BORDER-'.$side.'-'.$el])) {	// e.g. $b['BORDER-TOP-STYLE']
		$s = trim($a['BORDER-'.$side.'-'.$el]);
		if (isset($b['BORDER-'.$side])) {	// e.g. $b['BORDER-TOP']
			$p = trim($b['BORDER-'.$side]);
		}
		else { $p = ''; }
		if ($el=='STYLE') {
			if ($p) { $b['BORDER-'.$side] = preg_replace('/(\S+)\s+(\S+)\s+(\S+)/', '\\1 '.$s.' \\3', $p); }
			else { $b['BORDER-'.$side] = '0px '.$s.' #000000'; }
		}
		else if ($el=='WIDTH') {
			if ($p) { $b['BORDER-'.$side] = preg_replace('/(\S+)\s+(\S+)\s+(\S+)/', $s.' \\2 \\3', $p); }
			else { $b['BORDER-'.$side] = $s.' none #000000'; }
		}
		else if ($el=='COLOR') {
			if ($p) { $b['BORDER-'.$side] = preg_replace('/(\S+)\s+(\S+)\s+(\S+)/', '\\1 \\2 '.$s, $p); }
			else { $b['BORDER-'.$side] = '0px none '.$s; }
		}
		unset($a['BORDER-'.$side.'-'.$el]);
	}
    }
  }
}


function MergeCSS($inherit,$tag,$attr) {
	$p = array();
	$zp = array(); 

	$classes = array();
	if (isset($attr['CLASS'])) {
		$classes = preg_split('/\s+/',$attr['CLASS']);
	}
	// mPDF 5.0.05
	if (!isset($attr['ID'])) { $attr['ID']=''; }
	//===============================================
	//===============================================
	//===============================================
	// Set Inherited properties
	if ($inherit == 'BLOCK') {
		if (isset($this->blk[$this->blklvl-1]['cascadeCSS']) && is_array($this->blk[$this->blklvl-1]['cascadeCSS'])) {
		   foreach($this->blk[$this->blklvl-1]['cascadeCSS'] AS $k=>$v) {
				$this->blk[$this->blklvl]['cascadeCSS'][$k] = $v;

		   }
		}

		//===============================================
		// Save Cascading CSS e.g. "div.topic p" at this block level
		$this->_mergeFullCSS($this->cascadeCSS, $this->blk[$this->blklvl]['cascadeCSS'], $tag, $classes, $attr['ID']);
		//===============================================
		// Cascading forward CSS
		//===============================================
		$this->_mergeFullCSS($this->blk[$this->blklvl-1]['cascadeCSS'], $this->blk[$this->blklvl]['cascadeCSS'], $tag, $classes, $attr['ID']);
		//===============================================
		  // Block properties
		  if (isset($this->blk[$this->blklvl-1]['margin_collapse']) && $this->blk[$this->blklvl-1]['margin_collapse']) { $p['MARGIN-COLLAPSE'] = 'COLLAPSE'; }	// custom tag, but follows CSS principle that border-collapse is inherited
		  if (isset($this->blk[$this->blklvl-1]['line_height']) && $this->blk[$this->blklvl-1]['line_height']) { $p['LINE-HEIGHT'] = $this->blk[$this->blklvl-1]['line_height']; }
		  if (isset($this->blk[$this->blklvl-1]['align']) && $this->blk[$this->blklvl-1]['align']) { 
			if ($this->blk[$this->blklvl-1]['align'] == 'L') { $p['TEXT-ALIGN'] = 'left'; } 
			else if ($this->blk[$this->blklvl-1]['align'] == 'J') { $p['TEXT-ALIGN'] = 'justify'; } 
			else if ($this->blk[$this->blklvl-1]['align'] == 'R') { $p['TEXT-ALIGN'] = 'right'; } 
			else if ($this->blk[$this->blklvl-1]['align'] == 'C') { $p['TEXT-ALIGN'] = 'center'; } 
		  }
		  if ($this->ColActive || $this->keep_block_together) { 
		  	if (isset($this->blk[$this->blklvl-1]['bgcolor']) && $this->blk[$this->blklvl-1]['bgcolor']) { // Doesn't officially inherit, but default value is transparent (?=inherited)
				$cor = $this->blk[$this->blklvl-1]['bgcolorarray' ];
				$p['BACKGROUND-COLOR'] = 'RGB('.$cor['R'].','.$cor['G'].','.$cor['B'].')';
			}
		  }

		if (isset($this->blk[$this->blklvl-1]['text_indent']) && ($this->blk[$this->blklvl-1]['text_indent'] || $this->blk[$this->blklvl-1]['text_indent']===0)) { $p['TEXT-INDENT'] = $this->blk[$this->blklvl-1]['text_indent']; }

		$biilp = $this->blk[$this->blklvl-1]['InlineProperties'];
		if (isset($biilp[ 'family' ]) && $biilp[ 'family' ]) { $p['FONT-FAMILY'] = $biilp[ 'family' ]; }
		if (isset($biilp[ 'I' ]) && $biilp[ 'I' ]) { $p['FONT-STYLE'] = 'italic'; }
		if (isset($biilp[ 'sizePt' ]) && $biilp[ 'sizePt' ]) { $p['FONT-SIZE'] = $biilp[ 'sizePt' ] . 'pt'; }
		if (isset($biilp[ 'B' ]) && $biilp[ 'B' ]) { $p['FONT-WEIGHT'] = 'bold'; }
		if (isset($biilp[ 'colorarray' ]) && $biilp[ 'colorarray' ]) { 
			$cor = $biilp[ 'colorarray' ];
			$p['COLOR'] = 'RGB('.$cor['R'].','.$cor['G'].','.$cor['B'].')';
		}
		if (isset($biilp[ 'toupper' ]) && $biilp[ 'toupper' ]) { $p['TEXT-TRANSFORM'] = 'uppercase'; }
		else if (isset($biilp[ 'tolower' ]) && $biilp[ 'tolower' ]) { $p['TEXT-TRANSFORM'] = 'lowercase'; }
			// CSS says text-decoration is not inherited, but IE7 does?? 
		if (isset($biilp[ 'underline' ]) && $biilp[ 'underline' ]) { $p['TEXT-DECORATION'] = 'underline'; }
		if (isset($biilp[ 'smCaps' ]) && $biilp[ 'smCaps' ]) { $p['FONT-VARIANT'] = 'small-caps'; }	// mPDF 5.0

	}
	//===============================================
	//===============================================
	//===============================================
	//===============================================
	// DEFAULT for this TAG set in DefaultCSS
	if (isset($this->defaultCSS[$tag])) { 
			$zp = $this->fixCSS($this->defaultCSS[$tag]);
			if (is_array($zp)) { 	// Default overwrites Inherited
				$p = array_merge($p,$zp); 	// !! Note other way round !!
				$this->_mergeBorders($p,$zp);
			}
	}
	//===============================================
	//===============================================
	// STYLESHEET TAG e.g. h1  p  div  table
	if (isset($this->CSS[$tag]) && $this->CSS[$tag]) { 
			$zp = $this->CSS[$tag];
			if (is_array($zp)) { 
				$p = array_merge($p,$zp); 
				$this->_mergeBorders($p,$zp);
			}
	}
	//===============================================
	// STYLESHEET CLASS e.g. .smallone{}  .redletter{}
	foreach($classes AS $class) {
			$zp = array();
			if (isset($this->CSS['CLASS>>'.$class]) && $this->CSS['CLASS>>'.$class]) { $zp = $this->CSS['CLASS>>'.$class]; }
			if (is_array($zp)) { 
				$p = array_merge($p,$zp); 
				$this->_mergeBorders($p,$zp);
			}
	}
	//===============================================
	// STYLESHEET ID e.g. #smallone{}  #redletter{}
	if (isset($attr['ID']) && isset($this->CSS['ID>>'.$attr['ID']]) && $this->CSS['ID>>'.$attr['ID']]) {
			$zp = $this->CSS['ID>>'.$attr['ID']];
			if (is_array($zp)) { 
				$p = array_merge($p,$zp); 
				$this->_mergeBorders($p,$zp);
			}
	}
	//===============================================
	// STYLESHEET CLASS e.g. p.smallone{}  div.redletter{}
	foreach($classes AS $class) {
			$zp = array();
			if (isset($this->CSS[$tag.'>>CLASS>>'.$class]) && $this->CSS[$tag.'>>CLASS>>'.$class]) { $zp = $this->CSS[$tag.'>>CLASS>>'.$class]; }
			if (is_array($zp)) { 
				$p = array_merge($p,$zp); 
				$this->_mergeBorders($p,$zp);
			}
	}
	//===============================================
	// STYLESHEET CLASS e.g. p#smallone{}  div#redletter{}
	if (isset($attr['ID']) && isset($this->CSS[$tag.'>>ID>>'.$attr['ID']]) && $this->CSS[$tag.'>>ID>>'.$attr['ID']]) {
			$zp = $this->CSS[$tag.'>>ID>>'.$attr['ID']];
			if (is_array($zp)) { 
				$p = array_merge($p,$zp); 
				$this->_mergeBorders($p,$zp);
			}
	}
	//===============================================
	// Cascaded e.g. div.class p only works for block level
	if ($inherit == 'BLOCK') {
		$this->_set_mergedCSS($this->blk[$this->blklvl-1]['cascadeCSS'][$tag], $p);
		foreach($classes AS $class) {
			$this->_set_mergedCSS($this->blk[$this->blklvl-1]['cascadeCSS']['CLASS>>'.$class], $p);
		}
		$this->_set_mergedCSS($this->blk[$this->blklvl-1]['cascadeCSS']['ID>>'.$attr['ID']], $p);
		foreach($classes AS $class) {
			$this->_set_mergedCSS($this->blk[$this->blklvl-1]['cascadeCSS'][$tag.'>>CLASS>>'.$class], $p);
		}
		$this->_set_mergedCSS($this->blk[$this->blklvl-1]['cascadeCSS'][$tag.'>>ID>>'.$attr['ID']], $p);
	}
	else if ($inherit == 'INLINE') {
		$this->_set_mergedCSS($this->blk[$this->blklvl]['cascadeCSS'][$tag], $p);
		foreach($classes AS $class) {
			$this->_set_mergedCSS($this->blk[$this->blklvl]['cascadeCSS']['CLASS>>'.$class], $p);
		}
		$this->_set_mergedCSS($this->blk[$this->blklvl]['cascadeCSS']['ID>>'.$attr['ID']], $p);
		foreach($classes AS $class) {
			$this->_set_mergedCSS($this->blk[$this->blklvl]['cascadeCSS'][$tag.'>>CLASS>>'.$class], $p);
		}
		$this->_set_mergedCSS($this->blk[$this->blklvl]['cascadeCSS'][$tag.'>>ID>>'.$attr['ID']], $p);
	}
	//===============================================
	//===============================================
	//===============================================
	// INLINE STYLE e.g. style="CSS:property"
	if (isset($attr['STYLE'])) {
			$zp = $this->readInlineCSS($attr['STYLE']);
			if (is_array($zp)) { 
				$p = array_merge($p,$zp); 
				$this->_mergeBorders($p,$zp);
			}
	}
	//===============================================
	//===============================================
	// INLINE ATTRIBUTES e.g. .. ALIGN="CENTER">
	if (isset($attr['LANG']) and $attr['LANG']!='') {
			$p['LANG'] = $attr['LANG'];
	}
	if (isset($attr['COLOR']) and $attr['COLOR']!='') {
			$p['COLOR'] = $attr['COLOR'];
	}
	if ($tag != 'INPUT') {
		if (isset($attr['WIDTH']) and $attr['WIDTH']!='') {
			$p['WIDTH'] = $attr['WIDTH'];
		}
		if (isset($attr['HEIGHT']) and $attr['HEIGHT']!='') {
			$p['HEIGHT'] = $attr['HEIGHT'];
		}
	}
	if ($tag == 'FONT') {
		if (isset($attr['FACE'])) {
			$p['FONT-FAMILY'] = $attr['FACE'];
		}
		if (isset($attr['SIZE']) and $attr['SIZE']!='') {
			$s = '';
			if ($attr['SIZE'] === '+1') { $s = '120%'; }
			else if ($attr['SIZE'] === '-1') { $s = '86%'; }
			else if ($attr['SIZE'] === '1') { $s = 'XX-SMALL'; }
			else if ($attr['SIZE'] == '2') { $s = 'X-SMALL'; }
			else if ($attr['SIZE'] == '3') { $s = 'SMALL'; }
			else if ($attr['SIZE'] == '4') { $s = 'MEDIUM'; }
			else if ($attr['SIZE'] == '5') { $s = 'LARGE'; }
			else if ($attr['SIZE'] == '6') { $s = 'X-LARGE'; }
			else if ($attr['SIZE'] == '7') { $s = 'XX-LARGE'; }
			if ($s) $p['FONT-SIZE'] = $s;
		}
	}
	if (isset($attr['VALIGN']) and $attr['VALIGN']!='') {
		$p['VERTICAL-ALIGN'] = $attr['VALIGN'];
	}
	if (isset($attr['VSPACE']) and $attr['VSPACE']!='') {
		$p['MARGIN-TOP'] = $attr['VSPACE'];
		$p['MARGIN-BOTTOM'] = $attr['VSPACE'];
	}
	if (isset($attr['HSPACE']) and $attr['HSPACE']!='') {
		$p['MARGIN-LEFT'] = $attr['HSPACE'];
		$p['MARGIN-RIGHT'] = $attr['HSPACE'];
	}
	//===============================================
	return $p;
}



function PreviewBlockCSS($tag,$attr) {
	// Looks ahead from current block level to a new level
	$p = array();
	$zp = array(); 
	$oldcascadeCSS = $this->blk[$this->blklvl]['cascadeCSS'];
	$classes = array();
	if (isset($attr['CLASS'])) { $classes = preg_split('/\s+/',$attr['CLASS']); }
	//===============================================
	// DEFAULT for this TAG set in DefaultCSS
	if (isset($this->defaultCSS[$tag])) { 
		$zp = $this->fixCSS($this->defaultCSS[$tag]);
		if (is_array($zp)) { $p = array_merge($zp,$p); }	// Inherited overwrites default
	}
	// STYLESHEET TAG e.g. h1  p  div  table
	if (isset($this->CSS[$tag])) { 
		$zp = $this->CSS[$tag];
		if (is_array($zp)) { $p = array_merge($p,$zp); }
	}
	// STYLESHEET CLASS e.g. .smallone{}  .redletter{}
	foreach($classes AS $class) {
		$zp = array(); 
		if (isset($this->CSS['CLASS>>'.$class])) { $zp = $this->CSS['CLASS>>'.$class]; }
		if (is_array($zp)) { $p = array_merge($p,$zp); }
	}
	// STYLESHEET ID e.g. #smallone{}  #redletter{}
	if (isset($attr['ID']) && isset($this->CSS['ID>>'.$attr['ID']])) {
		$zp = $this->CSS['ID>>'.$attr['ID']];
		if (is_array($zp)) { $p = array_merge($p,$zp); }
	}
	// STYLESHEET CLASS e.g. p.smallone{}  div.redletter{}
	foreach($classes AS $class) {
		$zp = array(); 
		if (isset($this->CSS[$tag.'>>CLASS>>'.$class])) { $zp = $this->CSS[$tag.'>>CLASS>>'.$class]; }
		if (is_array($zp)) { $p = array_merge($p,$zp); }
	}
	// STYLESHEET CLASS e.g. p#smallone{}  div#redletter{}
	if (isset($attr['ID']) && isset($this->CSS[$tag.'>>ID>>'.$attr['ID']])) {
		$zp = $this->CSS[$tag.'>>ID>>'.$attr['ID']];
		if (is_array($zp)) { $p = array_merge($p,$zp); }
	}
	//===============================================
	// STYLESHEET TAG e.g. div h1    div p

	$this->_set_mergedCSS($oldcascadeCSS[$tag], $p);
	// STYLESHEET CLASS e.g. .smallone{}  .redletter{}
	foreach($classes AS $class) {
	  
	  $this->_set_mergedCSS($oldcascadeCSS['CLASS>>'.$class], $p);
	}
	// STYLESHEET CLASS e.g. #smallone{}  #redletter{}
	if (isset($attr['ID'])) {
	  
	  $this->_set_mergedCSS($oldcascadeCSS['ID>>'.$attr['ID']], $p);
	}
	// STYLESHEET CLASS e.g. div.smallone{}  p.redletter{}
	foreach($classes AS $class) {
	  
	  $this->_set_mergedCSS($oldcascadeCSS[$tag.'>>CLASS>>'.$class], $p);
	}
	// STYLESHEET CLASS e.g. div#smallone{}  p#redletter{}
	if (isset($attr['ID'])) {
	  
	  $this->_set_mergedCSS($oldcascadeCSS[$tag.'>>ID>>'.$attr['ID']], $p);
	}
	//===============================================
	// INLINE STYLE e.g. style="CSS:property"
	if (isset($attr['STYLE'])) {
		$zp = $this->readInlineCSS($attr['STYLE']);
		if (is_array($zp)) { $p = array_merge($p,$zp); }
	}
	//===============================================
	return $p;
}







function OpenTag($tag,$attr)
{

  // What this gets: < $tag $attr['WIDTH']="90px" > does not get content here </closeTag here>
  // Correct tags where HTML specifies optional end tags,
  // and/or does not allow nesting e.g. P inside P, or 
  if ($this->allow_html_optional_endtags) {
    if (($tag == 'P' || $tag == 'DIV' || $tag == 'H1' || $tag == 'H2' || $tag == 'H3' || $tag == 'H4' || $tag == 'H5' || $tag == 'H6' || $tag == 'UL' || $tag == 'OL' || $tag == 'TABLE' || $tag=='PRE' || $tag=='FORM' || $tag=='ADDRESS' || $tag=='BLOCKQUOTE' || $tag=='CENTER' || $tag=='DL' || $tag == 'HR' ) && $this->lastoptionaltag == 'P') { $this->CloseTag($this->lastoptionaltag ); }
    if ($tag == 'DD' && $this->lastoptionaltag == 'DD') { $this->CloseTag($this->lastoptionaltag ); }
    if ($tag == 'DD' && $this->lastoptionaltag == 'DT') { $this->CloseTag($this->lastoptionaltag ); }
    if ($tag == 'DT' && $this->lastoptionaltag == 'DD') { $this->CloseTag($this->lastoptionaltag ); }
    if ($tag == 'DT' && $this->lastoptionaltag == 'DT') { $this->CloseTag($this->lastoptionaltag ); }
    if ($tag == 'LI' && $this->lastoptionaltag == 'LI') { $this->CloseTag($this->lastoptionaltag ); }
    if ($tag == 'OPTION' && $this->lastoptionaltag == 'OPTION') { $this->CloseTag($this->lastoptionaltag ); }
  }

  $align = array('left'=>'L','center'=>'C','right'=>'R','top'=>'T','text-top'=>'TT','middle'=>'M','baseline'=>'BS','bottom'=>'B','text-bottom'=>'TB','justify'=>'J');

  $this->ignorefollowingspaces=false;

  //Opening tag
  switch($tag){

     case 'DOTTAB': 
	$objattr = array();
	$objattr['type'] = 'dottab';
	$dots=str_repeat('.', 3)."  ";	// minimum number of dots
	$objattr['width'] = $this->GetStringWidth($dots);
	$objattr['margin_top'] = 0;
	$objattr['margin_bottom'] = 0;
	$objattr['margin_left'] = 0;
	$objattr['margin_right'] = 0;
	$objattr['height'] = 0;
	$objattr['colorarray'] = $this->colorarray;  // mPDF 5.0
	$objattr['border_top']['w'] = 0;
	$objattr['border_bottom']['w'] = 0;
	$objattr['border_left']['w'] = 0;
	$objattr['border_right']['w'] = 0;
	$e = "\xbb\xa4\xactype=dottab,objattr=".serialize($objattr)."\xbb\xa4\xac";
		$this->textbuffer[] = array($e,$this->HREF,$this->currentfontstyle,$this->colorarray,$this->currentfontfamily,$this->SUP,$this->SUB,'',$this->strike,$this->outlineparam,$this->spanbgcolorarray,$this->currentfontsize,$this->ReqFontStyle);
	break;

     case 'PAGEHEADER': 
     case 'PAGEFOOTER':
	$this->ignorefollowingspaces = true; 
	if ($attr['NAME']) { $pname = $attr['NAME']; }
	else { $pname = '_default'; }

		if ($tag=='PAGEHEADER') { $p = &$this->pageheaders[$pname]; }
		else { $p = &$this->pagefooters[$pname]; }

		$p['L']=array();
		$p['C']=array();
		$p['R']=array();
		$p['L']['font-style'] = ''; 
		$p['C']['font-style'] = ''; 
		$p['R']['font-style'] = ''; 

		if (isset($attr['CONTENT-LEFT'])) {
			$p['L']['content'] = $attr['CONTENT-LEFT'];
		}
		if (isset($attr['CONTENT-CENTER'])) {
			$p['C']['content'] = $attr['CONTENT-CENTER'];
		}
		if (isset($attr['CONTENT-RIGHT'])) {
			$p['R']['content'] = $attr['CONTENT-RIGHT'];
		}

		if (isset($attr['HEADER-STYLE']) || isset($attr['FOOTER-STYLE'])) {	// font-family,size,weight,style,color
			if ($tag=='PAGEHEADER') { $properties = $this->readInlineCSS($attr['HEADER-STYLE']); }
			else { $properties = $this->readInlineCSS($attr['FOOTER-STYLE']); }
			if (isset($properties['FONT-FAMILY'])) { 
				$p['L']['font-family'] = $properties['FONT-FAMILY']; 
				$p['C']['font-family'] = $properties['FONT-FAMILY']; 
				$p['R']['font-family'] = $properties['FONT-FAMILY']; 
			}
			if (isset($properties['FONT-SIZE'])) { 
				$p['L']['font-size'] = $this->ConvertSize($properties['FONT-SIZE']) * $this->k; 
				$p['C']['font-size'] = $this->ConvertSize($properties['FONT-SIZE']) * $this->k; 
				$p['R']['font-size'] = $this->ConvertSize($properties['FONT-SIZE']) * $this->k; 
			}
			if (isset($properties['FONT-WEIGHT']) && $properties['FONT-WEIGHT']=='BOLD') { 
				$p['L']['font-style'] = 'B'; 
				$p['C']['font-style'] = 'B'; 
				$p['R']['font-style'] = 'B'; 
			}
			if (isset($properties['FONT-STYLE']) && $properties['FONT-STYLE']=='ITALIC') { 
				$p['L']['font-style'] .= 'I'; 
				$p['C']['font-style'] .= 'I'; 
				$p['R']['font-style'] .= 'I'; 
			}
			if (isset($properties['COLOR'])) { 
				$p['L']['color'] = $properties['COLOR']; 
				$p['C']['color'] = $properties['COLOR']; 
				$p['R']['color'] = $properties['COLOR']; 
			}
		}
		if (isset($attr['HEADER-STYLE-LEFT']) || isset($attr['FOOTER-STYLE-LEFT'])) {
			if ($tag=='PAGEHEADER') { $properties = $this->readInlineCSS($attr['HEADER-STYLE-LEFT']); }
			else { $properties = $this->readInlineCSS($attr['FOOTER-STYLE-LEFT']); }
			if (isset($properties['FONT-FAMILY'])) { $p['L']['font-family'] = $properties['FONT-FAMILY']; }
			if (isset($properties['FONT-SIZE'])) { $p['L']['font-size'] = $this->ConvertSize($properties['FONT-SIZE']) * $this->k; }
			if (isset($properties['FONT-WEIGHT']) && $properties['FONT-WEIGHT']=='BOLD') { $p['L']['font-style'] ='B'; }
			if (isset($properties['FONT-STYLE']) && $properties['FONT-STYLE']=='ITALIC') { $p['L']['font-style'] .='I'; }
			if (isset($properties['COLOR'])) { $p['L']['color'] = $properties['COLOR']; }
		}
		if (isset($attr['HEADER-STYLE-CENTER']) || isset($attr['FOOTER-STYLE-CENTER'])) {
			if ($tag=='PAGEHEADER') { $properties = $this->readInlineCSS($attr['HEADER-STYLE-CENTER']); }
			else { $properties = $this->readInlineCSS($attr['FOOTER-STYLE-CENTER']); }
			if (isset($properties['FONT-FAMILY'])) { $p['C']['font-family'] = $properties['FONT-FAMILY']; }
			if (isset($properties['FONT-SIZE'])) { $p['C']['font-size'] = $this->ConvertSize($properties['FONT-SIZE']) * $this->k; }
			if (isset($properties['FONT-WEIGHT']) && $properties['FONT-WEIGHT']=='BOLD') { $p['C']['font-style'] = 'B'; }
			if (isset($properties['FONT-STYLE']) && $properties['FONT-STYLE']=='ITALIC') { $p['C']['font-style'] .= 'I'; }
			if (isset($properties['COLOR'])) { $p['C']['color'] = $properties['COLOR']; }
		}
		if (isset($attr['HEADER-STYLE-RIGHT']) || isset($attr['FOOTER-STYLE-RIGHT'])) {
			if ($tag=='PAGEHEADER') { $properties = $this->readInlineCSS($attr['HEADER-STYLE-RIGHT']); }
			else { $properties = $this->readInlineCSS($attr['FOOTER-STYLE-RIGHT']); }
			if (isset($properties['FONT-FAMILY'])) { $p['R']['font-family'] = $properties['FONT-FAMILY']; }
			if (isset($properties['FONT-SIZE'])) { $p['R']['font-size'] = $this->ConvertSize($properties['FONT-SIZE']) * $this->k; }
			if (isset($properties['FONT-WEIGHT']) && $properties['FONT-WEIGHT']=='BOLD') { $p['R']['font-style'] = 'B'; }
			if (isset($properties['FONT-STYLE']) && $properties['FONT-STYLE']=='ITALIC') { $p['R']['font-style'] .= 'I'; }
			if (isset($properties['COLOR'])) { $p['R']['color'] = $properties['COLOR']; }
		}
		if (isset($attr['LINE']) && $attr['LINE']) {	// 0|1|on|off
			if ($attr['LINE']=='1' || strtoupper($attr['LINE'])=='ON') { $lineset=1; }
			else { $lineset=0; }
			$p['line'] = $lineset;
		}
	break;


     case 'SETHTMLPAGEHEADER': 
     case 'SETHTMLPAGEFOOTER':
	$this->ignorefollowingspaces = true; 
	if (isset($attr['NAME']) && $attr['NAME']) { $pname = $attr['NAME']; }
	else { $pname = '_default'; }
	if (isset($attr['PAGE']) && $attr['PAGE']) { 	// O|odd|even|E|ALL|[blank]
		if (strtoupper($attr['PAGE'])=='O' || strtoupper($attr['PAGE'])=='ODD') { $side='odd'; }
		else if (strtoupper($attr['PAGE'])=='E' || strtoupper($attr['PAGE'])=='EVEN') { $side='even'; }
		else if (strtoupper($attr['PAGE'])=='ALL') { $side='both'; }
		else { $side='odd'; }
	}
	else { $side='odd'; }
	if (isset($attr['VALUE']) && $attr['VALUE']) { 	// -1|1|on|off
		if ($attr['VALUE']=='1' || strtoupper($attr['VALUE'])=='ON') { $set=1; }
		else if ($attr['VALUE']=='-1' || strtoupper($attr['VALUE'])=='OFF') { $set=0; }
		else { $set=1; }
	}
	else { $set=1; }
	if (isset($attr['SHOW-THIS-PAGE']) && $attr['SHOW-THIS-PAGE'] && $tag=='SETHTMLPAGEHEADER') { $write = 1; }
	else { $write = 0; }
	if ($side=='odd' || $side=='both') {
		if ($set && $tag=='SETHTMLPAGEHEADER') { $this->SetHTMLHeader($this->pageHTMLheaders[$pname],'O',$write); }
		else if ($set && $tag=='SETHTMLPAGEFOOTER') { $this->SetHTMLFooter($this->pageHTMLfooters[$pname],'O'); }
		else if ($tag=='SETHTMLPAGEHEADER') { $this->SetHTMLHeader('','O'); }
		else { $this->SetHTMLFooter('','O'); }
	}
	if ($side=='even' || $side=='both') {
		if ($set && $tag=='SETHTMLPAGEHEADER') { $this->SetHTMLHeader($this->pageHTMLheaders[$pname],'E',$write); }
		else if ($set && $tag=='SETHTMLPAGEFOOTER') { $this->SetHTMLFooter($this->pageHTMLfooters[$pname],'E'); }
		else if ($tag=='SETHTMLPAGEHEADER') { $this->SetHTMLHeader('','E'); }
		else { $this->SetHTMLFooter('','E'); }
	}
	break;

     case 'SETPAGEHEADER': 
     case 'SETPAGEFOOTER':
	$this->ignorefollowingspaces = true; 
	if (isset($attr['NAME']) && $attr['NAME']) { $pname = $attr['NAME']; }
	else { $pname = '_default'; }
	if (isset($attr['PAGE']) && $attr['PAGE']) { 	// O|odd|even|E|ALL|[blank]
		if (strtoupper($attr['PAGE'])=='O' || strtoupper($attr['PAGE'])=='ODD') { $side='odd'; }
		else if (strtoupper($attr['PAGE'])=='E' || strtoupper($attr['PAGE'])=='EVEN') { $side='even'; }
		else if (strtoupper($attr['PAGE'])=='ALL') { $side='both'; }
		else { $side='odd'; }
	}
	else { $side='odd'; }
	if (isset($attr['VALUE']) && $attr['VALUE']) { 	// -1|1|on|off
		if ($attr['VALUE']=='1' || strtoupper($attr['VALUE'])=='ON') { $set=1; }
		else if ($attr['VALUE']=='-1' || strtoupper($attr['VALUE'])=='OFF') { $set=0; }
		else { $set=1; }
	}
	else { $set=1; }
	if ($side=='odd' || $side=='both') {
		if ($set && $tag=='SETPAGEHEADER') { $this->headerDetails['odd'] = $this->pageheaders[$pname]; }
		else if ($set && $tag=='SETPAGEFOOTER') { $this->footerDetails['odd'] = $this->pagefooters[$pname]; }
		else if ($tag=='SETPAGEHEADER') { $this->headerDetails['odd'] = array(); }
		else { $this->footerDetails['odd'] = array(); }
		if (!$this->mirrorMargins || ($this->page)%2!=0) {	// ODD
			if ($tag=='SETPAGEHEADER') { $this->_setAutoHeaderHeight($this->headerDetails['odd'],$this->HTMLHeader); }
			if ($tag=='SETPAGEFOOTER') { $this->_setAutoFooterHeight($this->footerDetails['odd'],$this->HTMLFooter); }
		}
	}
	if ($side=='even' || $side=='both') {
		if ($set && $tag=='SETPAGEHEADER') { $this->headerDetails['even'] = $this->pageheaders[$pname]; }
		else if ($set && $tag=='SETPAGEFOOTER') { $this->footerDetails['even'] = $this->pagefooters[$pname]; }
		else if ($tag=='SETPAGEHEADER') { $this->headerDetails['even'] = array(); }
		else { $this->footerDetails['even'] = array(); }
		if ($this->mirrorMargins && ($this->page)%2==0) {	// EVEN
			if ($tag=='SETPAGEHEADER') { $this->_setAutoHeaderHeight($this->headerDetails['even'],$this->HTMLHeaderE); }
			if ($tag=='SETPAGEFOOTER') { $this->_setAutoFooterHeight($this->footerDetails['even'],$this->HTMLFooterE); }
		}
	}
	if (isset($attr['SHOW-THIS-PAGE']) && $attr['SHOW-THIS-PAGE'] && $tag=='SETPAGEHEADER') {
		$this->Header();
	}
	break;




    case 'PAGE_BREAK': //custom-tag
    case 'PAGEBREAK': //custom-tag
    case 'NEWPAGE': //custom-tag
    case 'FORMFEED': //custom-tag

	$save_blklvl = $this->blklvl;
	$save_blk = $this->blk;
	$save_silp = $this->saveInlineProperties();
	$save_spanlvl = $this->spanlvl;
	$save_ilp = $this->InlineProperties;

	// Close any open block tags
	for ($b= $this->blklvl;$b>0;$b--) { $this->CloseTag($this->blk[$b]['tag']); }
	if(!empty($this->textbuffer))  {	//Output previously buffered content
   	  	$this->printbuffer($this->textbuffer);
        	$this->textbuffer=array(); 
      }
	$this->ignorefollowingspaces = true;
	$save_cols = false;


	if (isset($attr['SHEET-SIZE']) && $tag != 'FORMFEED' && !$this->restoreBlockPageBreaks) { 
		// Convert to same types as accepted in initial mPDF() A4, A4-L, or array(w,h)
		$prop = preg_split('/\s+/',trim($attr['SHEET-SIZE']));
		if (count($prop) == 2 ) {
			$newformat = array($this->ConvertSize($prop[0]), $this->ConvertSize($prop[1]));
		}
		else { $newformat = $attr['SHEET-SIZE']; }
	}
	else { $newformat = ''; }


	$mgr = $mgl = $mgt = $mgb = $mgh = $mgf = '';
	if (isset($attr['MARGIN-RIGHT'])) { $mgr = $this->ConvertSize($attr['MARGIN-RIGHT'],$this->w,$this->FontSize,false); }
	if (isset($attr['MARGIN-LEFT'])) { $mgl = $this->ConvertSize($attr['MARGIN-LEFT'],$this->w,$this->FontSize,false); }
	if (isset($attr['MARGIN-TOP'])) { $mgt = $this->ConvertSize($attr['MARGIN-TOP'],$this->w,$this->FontSize,false); }
	if (isset($attr['MARGIN-BOTTOM'])) { $mgb = $this->ConvertSize($attr['MARGIN-BOTTOM'],$this->w,$this->FontSize,false); }
	if (isset($attr['MARGIN-HEADER'])) { $mgh = $this->ConvertSize($attr['MARGIN-HEADER'],$this->w,$this->FontSize,false); }
	if (isset($attr['MARGIN-FOOTER'])) { $mgf = $this->ConvertSize($attr['MARGIN-FOOTER'],$this->w,$this->FontSize,false); }
	$ohname = $ehname = $ofname = $efname = '';
	if (isset($attr['ODD-HEADER-NAME'])) { $ohname = $attr['ODD-HEADER-NAME']; }
	if (isset($attr['EVEN-HEADER-NAME'])) { $ehname = $attr['EVEN-HEADER-NAME']; }
	if (isset($attr['ODD-FOOTER-NAME'])) { $ofname = $attr['ODD-FOOTER-NAME']; }
	if (isset($attr['EVEN-FOOTER-NAME'])) { $efname = $attr['EVEN-FOOTER-NAME']; }
	$ohvalue = $ehvalue = $ofvalue = $efvalue = 0;
	if (isset($attr['ODD-HEADER-VALUE']) && ($attr['ODD-HEADER-VALUE']=='1' || strtoupper($attr['ODD-HEADER-VALUE'])=='ON')) { $ohvalue = 1; }
	else if (isset($attr['ODD-HEADER-VALUE']) && ($attr['ODD-HEADER-VALUE']=='-1' || strtoupper($attr['ODD-HEADER-VALUE'])=='OFF')) { $ohvalue = -1; }
	if (isset($attr['EVEN-HEADER-VALUE']) && ($attr['EVEN-HEADER-VALUE']=='1' || strtoupper($attr['EVEN-HEADER-VALUE'])=='ON')) { $ehvalue = 1; }
	else if (isset($attr['EVEN-HEADER-VALUE']) && ($attr['EVEN-HEADER-VALUE']=='-1' || strtoupper($attr['EVEN-HEADER-VALUE'])=='OFF')) { $ehvalue = -1; }
	if (isset($attr['ODD-FOOTER-VALUE']) && ($attr['ODD-FOOTER-VALUE']=='1' || strtoupper($attr['ODD-FOOTER-VALUE'])=='ON')) { $ofvalue = 1; }
	else if (isset($attr['ODD-FOOTER-VALUE']) && ($attr['ODD-FOOTER-VALUE']=='-1' || strtoupper($attr['ODD-FOOTER-VALUE'])=='OFF')) { $ofvalue = -1; }
	if (isset($attr['EVEN-FOOTER-VALUE']) && ($attr['EVEN-FOOTER-VALUE']=='1' || strtoupper($attr['EVEN-FOOTER-VALUE'])=='ON')) { $efvalue = 1; }
	else if (isset($attr['EVEN-FOOTER-VALUE']) && ($attr['EVEN-FOOTER-VALUE']=='-1' || strtoupper($attr['EVEN-FOOTER-VALUE'])=='OFF')) { $efvalue = -1; }

	if (isset($attr['ORIENTATION']) && (strtoupper($attr['ORIENTATION'])=='L' || strtoupper($attr['ORIENTATION'])=='LANDSCAPE')) { $orient = 'L'; }
	else if (isset($attr['ORIENTATION']) && (strtoupper($attr['ORIENTATION'])=='P' || strtoupper($attr['ORIENTATION'])=='PORTRAIT')) { $orient = 'P'; }
	else { $orient = $this->CurOrientation; }

	if (isset($attr['PAGE-SELECTOR']) && $attr['PAGE-SELECTOR']) { $pagesel = $attr['PAGE-SELECTOR']; }
	else { $pagesel = ''; }

	$resetpagenum = '';
	$pagenumstyle = '';
	$suppress = '';
	if (isset($attr['RESETPAGENUM'])) { $resetpagenum = $attr['RESETPAGENUM']; }
	if (isset($attr['PAGENUMSTYLE'])) { $pagenumstyle = $attr['PAGENUMSTYLE']; }
	if (isset($attr['SUPPRESS'])) { $suppress = $attr['SUPPRESS']; }

	if ($tag == 'TOCPAGEBREAK') { $type = 'NEXT-ODD'; }
	else if(isset($attr['TYPE'])) { $type = strtoupper($attr['TYPE']); }
	else { $type = ''; }

	if ($type == 'E' || $type == 'EVEN') { $this->AddPage($orient,'E', $resetpagenum, $pagenumstyle, $suppress,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf,$ohname,$ehname,$ofname,$efname,$ohvalue,$ehvalue,$ofvalue,$efvalue,$pagesel,$newformat); }
	else if ($type == 'O' || $type == 'ODD') { $this->AddPage($orient,'O', $resetpagenum, $pagenumstyle, $suppress,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf,$ohname,$ehname,$ofname,$efname,$ohvalue,$ehvalue,$ofvalue,$efvalue,$pagesel,$newformat); }
	else if ($type == 'NEXT-ODD') { $this->AddPage($orient,'NEXT-ODD', $resetpagenum, $pagenumstyle, $suppress,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf,$ohname,$ehname,$ofname,$efname,$ohvalue,$ehvalue,$ofvalue,$efvalue,$pagesel,$newformat); }
	else if ($type == 'NEXT-EVEN') { $this->AddPage($orient,'NEXT-EVEN', $resetpagenum, $pagenumstyle, $suppress,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf,$ohname,$ehname,$ofname,$efname,$ohvalue,$ehvalue,$ofvalue,$efvalue,$pagesel,$newformat); }
	else { $this->AddPage($orient,'', $resetpagenum, $pagenumstyle, $suppress,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf,$ohname,$ehname,$ofname,$efname,$ohvalue,$ehvalue,$ofvalue,$efvalue,$pagesel,$newformat); }


	if (($tag == 'FORMFEED' || $this->restoreBlockPagebreaks) && !$this->tableLevel && !$this->listlvl) {
		$this->blk = $save_blk;
		// Re-open block tags
		$t = $this->blk[0]['tag'];
		$a = $this->blk[0]['attr'];
		$this->blklvl = 0; 
		for ($b=0; $b<=$save_blklvl;$b++) {
			$tc = $t;
			$ac = $a;
			$t = $this->blk[$b+1]['tag'];
			$a = $this->blk[$b+1]['attr'];
			unset($this->blk[$b+1]);
			$this->OpenTag($tc,$ac); 
		}
		$this->spanlvl = $save_spanlvl;
		$this->InlineProperties = $save_ilp;
		$this->restoreInlineProperties($save_silp);
	}

	break;





     case 'BOOKMARK':
	if (isset($attr['CONTENT'])) {
		$objattr = array();
		$objattr['CONTENT'] = htmlspecialchars_decode($attr['CONTENT'],ENT_QUOTES);
		$objattr['type'] = 'bookmark';
		if (isset($attr['LEVEL']) && $attr['LEVEL']) { $objattr['bklevel'] = $attr['LEVEL']; } else { $objattr['bklevel'] = 0; }
		$e = "\xbb\xa4\xactype=bookmark,objattr=".serialize($objattr)."\xbb\xa4\xac";
			$this->textbuffer[] = array($e);
	}
	break;





    case 'BDO':
	$this->biDirectional = true;
	break;


    case 'TTZ':
	$this->ttz = true;
	$this->InlineProperties[$tag] = $this->saveInlineProperties();
	$this->setCSS(array('FONT-FAMILY'=>'czapfdingbats','FONT-WEIGHT'=>'normal','FONT-STYLE'=>'normal'),'INLINE');
	break;

    case 'TTS':
	$this->tts = true;
	$this->InlineProperties[$tag] = $this->saveInlineProperties();
	$this->setCSS(array('FONT-FAMILY'=>'csymbol','FONT-WEIGHT'=>'normal','FONT-STYLE'=>'normal'),'INLINE');
	break;

    case 'TTA':
	$this->tta = true;
	$this->InlineProperties[$tag] = $this->saveInlineProperties();

	if (in_array($this->FontFamily,$this->mono_fonts)) {
		$this->setCSS(array('FONT-FAMILY'=>'ccourier'),'INLINE');
	}
	else if (in_array($this->FontFamily,$this->serif_fonts)) { 
		$this->setCSS(array('FONT-FAMILY'=>'ctimes'),'INLINE');
	}
	else {
		$this->setCSS(array('FONT-FAMILY'=>'chelvetica'),'INLINE');
	}
	break;



    // INLINE PHRASES OR STYLES
    case 'SUB':
    case 'SUP':
    case 'ACRONYM':
    case 'BIG':
    case 'SMALL':
    case 'INS':
    case 'S':
    case 'STRIKE':
    case 'DEL':
    case 'STRONG':
    case 'CITE':
    case 'Q':
    case 'EM':
    case 'B':
    case 'I':
    case 'U':
    case 'SAMP':
    case 'CODE':
    case 'KBD':
    case 'TT':
    case 'VAR':
    case 'FONT':
    case 'SPAN':

	if ($tag == 'SPAN') {
		$this->spanlvl++;
		$this->InlineProperties['SPAN'][$this->spanlvl] = $this->saveInlineProperties();
	}
	else { 
		$this->InlineProperties[$tag] = $this->saveInlineProperties(); 
	}
	$properties = $this->MergeCSS('INLINE',$tag,$attr);
	if (!empty($properties)) $this->setCSS($properties,'INLINE');
	break;


    case 'A':
	if (isset($attr['NAME']) and $attr['NAME'] != '') { 
		$e = '';
		if ($this->anchor2Bookmark) { 
			$objattr = array();
			$objattr['CONTENT'] = htmlspecialchars_decode($attr['NAME'],ENT_QUOTES);
			$objattr['type'] = 'bookmark';
			if (isset($attr['LEVEL']) && $attr['LEVEL']) { $objattr['bklevel'] = $attr['LEVEL']; } else { $objattr['bklevel'] = 0; }
			$e = "\xbb\xa4\xactype=bookmark,objattr=".serialize($objattr)."\xbb\xa4\xac";
		}
			$this->textbuffer[] = array($e,'','',array(),'',false,false,$attr['NAME']); //an internal link (adds a space for recognition)
	}
	if (isset($attr['HREF'])) { 
		$this->InlineProperties['A'] = $this->saveInlineProperties();
		$properties = $this->MergeCSS('',$tag,$attr);
		if (!empty($properties)) $this->setCSS($properties,'INLINE');
		$this->HREF=$attr['HREF'];
	}
	break;



    case 'BR':
	// Added mPDF 3.0 Float DIV - CLEAR
	if (isset($attr['STYLE'])) {
		$properties = $this->readInlineCSS($attr['STYLE']);
	}


		if (count($this->textbuffer)) {	// mPDF 5.0
			$this->textbuffer[count($this->textbuffer)-1][0] = preg_replace('/ $/','',$this->textbuffer[count($this->textbuffer)-1][0]);
		}
		$this->textbuffer[] = array("\n",$this->HREF,$this->currentfontstyle,$this->colorarray,$this->currentfontfamily,$this->SUP,$this->SUB,'',$this->strike,$this->outlineparam,$this->spanbgcolorarray,$this->currentfontsize,$this->ReqFontStyle);
	$this->ignorefollowingspaces = true; 
	$this->blockjustfinished=false;
	$this->listjustfinished=false;

	$this->linebreakjustfinished=true;
	break;


	// *********** BLOCKS  ********************

	//NB $outerblocktags = array('DIV','FORM','CENTER','DL');
	//NB $innerblocktags = array('P','BLOCKQUOTE','ADDRESS','PRE',''H1','H2','H3','H4','H5','H6','DT','DD');

    case 'PRE':
	$this->ispre=true;	// ADDED - Prevents left trim of textbuffer in printbuffer()

    case 'DIV':
    case 'FORM':
    case 'CENTER':

    case 'BLOCKQUOTE':
    case 'ADDRESS': 

    case 'P':
    case 'H1':
    case 'H2':
    case 'H3':
    case 'H4':
    case 'H5':
    case 'H6':
    case 'DL':
    case 'DT':
    case 'DD':
	$p = $this->PreviewBlockCSS($tag,$attr);
	if(isset($p['DISPLAY']) && strtolower($p['DISPLAY'])=='none') { 
		$this->blklvl++;
		$this->blk[$this->blklvl]['hide'] = true; 
		return; 
	}
	// Start Block
	$this->ignorefollowingspaces = true; 

	if ($this->blockjustfinished && !count($this->textbuffer) && $this->y != $this->tMargin && $this->collapseBlockMargins) { $lastbottommargin = $this->lastblockbottommargin; }
	else { $lastbottommargin = 0; }
	$this->lastblockbottommargin = 0;
	$this->blockjustfinished=false;


	$this->InlineProperties = array(); 
	$this->spanlvl = 0;
	$this->listjustfinished=false;
	$this->divbegin=true;

	$this->linebreakjustfinished=false;


	if ($tag == 'P' || $tag == 'DT' || $tag == 'DD') { $this->lastoptionaltag = $tag; } // Save current HTML specified optional endtag
	else { $this->lastoptionaltag = ''; }

	if ($this->lastblocklevelchange == 1) { $blockstate = 1; }	// Top margins/padding only
	else if ($this->lastblocklevelchange < 1) { $blockstate = 0; }	// NO margins/padding
	$this->printbuffer($this->textbuffer,$blockstate);
	$this->textbuffer=array();

	$this->blklvl++;

	$currblk =& $this->blk[$this->blklvl];
	$this->initialiseBlock($currblk);
	$prevblk =& $this->blk[$this->blklvl-1];

	$currblk['tag'] = $tag;
	$currblk['attr'] = $attr;

	$this->Reset();
	$properties = $this->MergeCSS('BLOCK',$tag,$attr);

	$pagesel = ''; 

	// If page-box has changed AND/OR PAGE-BREAK-BEFORE
	$save_cols = false;
	if (($pagesel && $pagesel != $this->page_box['current']) || (isset($properties['PAGE-BREAK-BEFORE']) && $properties['PAGE-BREAK-BEFORE'])) {
		if ($this->blklvl>1) {
			// Close any open block tags
			for ($b= $this->blklvl;$b>0;$b--) { $this->CloseTag($this->blk[$b]['tag']); }
			// Output any text left in buffer
			if (count($this->textbuffer)) { $this->printbuffer($this->textbuffer); $this->textbuffer=array(); }
		}


		// Must Add new page if changed page properties
		if (isset($properties['PAGE-BREAK-BEFORE'])) {
			if (strtoupper($properties['PAGE-BREAK-BEFORE']) == 'RIGHT') { $this->AddPage($this->CurOrientation,'NEXT-ODD','','','','','', '','', '','','','','','',0,0,0,0,$pagesel); }
			else if (strtoupper($properties['PAGE-BREAK-BEFORE']) == 'LEFT') { $this->AddPage($this->CurOrientation,'NEXT-EVEN','','','','','', '','', '','','','','','',0,0,0,0,$pagesel); }
			else if (strtoupper($properties['PAGE-BREAK-BEFORE']) == 'ALWAYS') { $this->AddPage($this->CurOrientation,'','','','','','', '','', '','','','','','',0,0,0,0,$pagesel); }
		}

		// if using htmlheaders, the headers need to be rewritten when new page
		// done by calling WriteHTML() within resethtmlheaders
		// so block is reset to 0 - now we need to resurrect it
		// As in WriteHTML() initialising
		$this->blklvl = 0;
		$this->lastblocklevelchange = 0;
		$this->blk = array();
		$this->initialiseBlock($this->blk[0]);
		$this->blk[0]['width'] =& $this->pgwidth;
		$this->blk[0]['inner_width'] =& $this->pgwidth;
		$this->blk[0]['blockContext'] = $this->blockContext;
		$properties = $this->MergeCSS('BLOCK','BODY','');
		$this->setCSS($properties,'','BODY'); 
		$this->blklvl++;
		$currblk =& $this->blk[$this->blklvl];
		$prevblk =& $this->blk[$this->blklvl-1];

		$this->initialiseBlock($currblk);
		$currblk['tag'] = $tag;
		$currblk['attr'] = $attr;

		$this->Reset();
		$properties = $this->MergeCSS('BLOCK',$tag,$attr);
	}


	if (isset($properties['PAGE-BREAK-INSIDE']) && strtoupper($properties['PAGE-BREAK-INSIDE']) == 'AVOID' && !$this->ColActive && !$this->keep_block_together) {
		$currblk['keep_block_together'] = 1;
		$this->kt_y00 = $this->y;	// mPDF 5.0
		$this->kt_p00 = $this->page;	// mPDF 5.0
		$this->keep_block_together = 1;
		$this->divbuffer = array();
		$this->ktLinks = array();
		$this->ktAnnots = array();
		$this->ktBlock = array();
		$this->ktReference = array();
		$this->ktBMoutlines = array();
		$this->_kttoc = array();
	}

	if ($lastbottommargin && $properties['MARGIN-TOP']) { $currblk['lastbottommargin'] = $lastbottommargin; }

	$this->setCSS($properties,'BLOCK',$tag); //name(id/class/style) found in the CSS array!
	$currblk['InlineProperties'] = $this->saveInlineProperties();


	if(isset($attr['ALIGN']) && $attr['ALIGN']) { $currblk['block-align'] = $align[strtolower($attr['ALIGN'])]; }


	if (isset($properties['HEIGHT'])) { $currblk['css_set_height'] = $this->ConvertSize($properties['HEIGHT'],($this->h - $this->tMargin - $this->bMargin),$this->FontSize,false); }
	else { $currblk['css_set_height'] = false; }


	// Added mPDF 3.0 Float DIV


	$container_w = $prevblk['inner_width'];
	$bdr = $currblk['border_right']['w'];
	$bdl = $currblk['border_left']['w'];
	$pdr = $currblk['padding_right'];
	$pdl = $currblk['padding_left'];

	if (isset($currblk['css_set_width'])) { $setwidth = $currblk['css_set_width']; }
	else { $setwidth = 0; }





	// Hanging indent - if negative indent: ensure padding is >= indent

	$cbti = $this->ConvertSize($currblk['text_indent'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); 
	if ($cbti < 0) {
	  $hangind = -($cbti);
		$currblk['padding_left'] = max($currblk['padding_left'],$hangind);
	}

	if (isset($currblk['css_set_width'])) {
	  if (isset($properties['MARGIN-LEFT']) && isset($properties['MARGIN-RIGHT']) && strtolower($properties['MARGIN-LEFT'])=='auto' && strtolower($properties['MARGIN-RIGHT'])=='auto') { 
		  // Try to reduce margins to accomodate - if still too wide, set margin-right/left=0 (reduces width)
		  $anyextra = $prevblk['inner_width'] - ($currblk['css_set_width'] + $currblk['border_left']['w'] + $currblk['padding_left'] + $currblk['border_right']['w'] + $currblk['padding_right']);
		  if ($anyextra>0) {
			$currblk['margin_left'] = $currblk['margin_right'] = $anyextra /2;
		  }
		  else {
			$currblk['margin_left'] = $currblk['margin_right'] = 0;
		  }
	  }
	  else if (isset($properties['MARGIN-LEFT']) && strtolower($properties['MARGIN-LEFT'])=='auto') { 
		  // Try to reduce margin-left to accomodate - if still too wide, set margin-left=0 (reduces width)
		  $currblk['margin_left'] = $prevblk['inner_width'] - ($currblk['css_set_width'] + $currblk['border_left']['w'] + $currblk['padding_left'] + $currblk['border_right']['w'] + $currblk['padding_right'] + $currblk['margin_right']);
		  if ($currblk['margin_left'] < 0) {
			$currblk['margin_left'] = 0;
		  }
	  }
	  else if (isset($properties['MARGIN-RIGHT']) && strtolower($properties['MARGIN-RIGHT'])=='auto') { 
		  // Try to reduce margin-right to accomodate - if still too wide, set margin-right=0 (reduces width)
		  $currblk['margin_right'] = $prevblk['inner_width'] - ($currblk['css_set_width'] + $currblk['border_left']['w'] + $currblk['padding_left'] + $currblk['border_right']['w'] + $currblk['padding_right'] + $currblk['margin_left']);
		  if ($currblk['margin_right'] < 0) {
			$currblk['margin_right'] = 0;
		  }
	  }
	  else { 
		// Try to reduce margin-left to accomodate - if still too wide, set margin-left=0 (reduces width)
		  // Try to reduce margin-right to accomodate - if still too wide, set margin-right=0 (reduces width)
		  $currblk['margin_right'] = $prevblk['inner_width'] - ($currblk['css_set_width'] + $currblk['border_left']['w'] + $currblk['padding_left'] + $currblk['border_right']['w'] + $currblk['padding_right'] + $currblk['margin_left']);
		  if ($currblk['margin_right'] < 0) {
			$currblk['margin_right'] = 0;
		  }
	  }
	}

	$currblk['outer_left_margin'] = $prevblk['outer_left_margin'] + $currblk['margin_left'] + $prevblk['border_left']['w'] + $prevblk['padding_left'];
	$currblk['outer_right_margin'] = $prevblk['outer_right_margin']  + $currblk['margin_right'] + $prevblk['border_right']['w'] + $prevblk['padding_right'];

	$currblk['width'] = $this->pgwidth - ($currblk['outer_right_margin'] + $currblk['outer_left_margin']);
	$currblk['inner_width'] = $currblk['width'] - ($currblk['border_left']['w'] + $currblk['padding_left'] + $currblk['border_right']['w'] + $currblk['padding_right']);

	// Check DIV is not now too narrow to fit text
	$mw = $this->GetStringWidth('WW');
	if ($currblk['inner_width'] < $mw) {
		$currblk['padding_left'] = 0;
		$currblk['padding_right'] = 0;
		$currblk['border_left']['w'] = 0.2;
		$currblk['border_right']['w'] = 0.2;
		$currblk['margin_left'] = 0;
		$currblk['margin_right'] = 0;
		$currblk['outer_left_margin'] = $prevblk['outer_left_margin'] + $currblk['margin_left'] + $prevblk['border_left']['w'] + $prevblk['padding_left'];
		$currblk['outer_right_margin'] = $prevblk['outer_right_margin']  + $currblk['margin_right'] + $prevblk['border_right']['w'] + $prevblk['padding_right'];
		$currblk['width'] = $this->pgwidth - ($currblk['outer_right_margin'] + $currblk['outer_left_margin']);
		$currblk['inner_width'] = $this->pgwidth - ($currblk['outer_right_margin'] + $currblk['outer_left_margin'] + $currblk['border_left']['w'] + $currblk['padding_left'] + $currblk['border_right']['w'] + $currblk['padding_right']);
//		if ($currblk['inner_width'] < $mw) { $this->Error("DIV is too narrow for text to fit!"); }
	}

	$this->x = $this->lMargin + $currblk['outer_left_margin'];


		$this->kwt = false; 

	//Save x,y coords in case we need to print borders...
	$currblk['y0'] = $this->y;
	$currblk['x0'] = $this->x;
	$currblk['startpage'] = $this->page;
	$this->oldy = $this->y;

	$this->lastblocklevelchange = 1 ;

	break;

    case 'HR':
	// Added mPDF 3.0 Float DIV - CLEAR
	if (isset($attr['STYLE'])) {
		$properties = $this->readInlineCSS($attr['STYLE']);
	}

	$this->ignorefollowingspaces = true; 

	$objattr = array();
		$objattr['margin_top'] = 0;
		$objattr['margin_bottom'] = 0;
		$objattr['margin_left'] = 0;
		$objattr['margin_right'] = 0;
		$objattr['width'] = 0;
		$objattr['height'] = 0;
		$objattr['border_top']['w'] = 0;
		$objattr['border_bottom']['w'] = 0;
		$objattr['border_left']['w'] = 0;
		$objattr['border_right']['w'] = 0;
	$properties = $this->MergeCSS('',$tag,$attr);
	if (isset($properties['MARGIN-TOP'])) { $objattr['margin_top'] = $this->ConvertSize($properties['MARGIN-TOP'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }
	if (isset($properties['MARGIN-BOTTOM'])) { $objattr['margin_bottom'] = $this->ConvertSize($properties['MARGIN-BOTTOM'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }
	if (isset($properties['WIDTH'])) { $objattr['width'] = $this->ConvertSize($properties['WIDTH'],$this->blk[$this->blklvl]['inner_width']); }
	if (isset($properties['TEXT-ALIGN'])) { $objattr['align'] = $align[strtolower($properties['TEXT-ALIGN'])]; }

	if (isset($properties['MARGIN-LEFT']) && strtolower($properties['MARGIN-LEFT'])=='auto') { 
		$objattr['align'] = 'R';
	}
	if (isset($properties['MARGIN-RIGHT']) && strtolower($properties['MARGIN-RIGHT'])=='auto') { 
		$objattr['align'] = 'L';
		if (isset($properties['MARGIN-RIGHT']) && strtolower($properties['MARGIN-RIGHT'])=='auto' && isset($properties['MARGIN-LEFT']) && strtolower($properties['MARGIN-LEFT'])=='auto') { 
			$objattr['align'] = 'C';
		}
	}
	if (isset($properties['COLOR'])) { $objattr['color'] = $this->ConvertColor($properties['COLOR']); }
	if (isset($properties['HEIGHT'])) { $objattr['linewidth'] = $this->ConvertSize($properties['HEIGHT'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }

	if(isset($attr['WIDTH']) && $attr['WIDTH'] != '') $objattr['width'] = $this->ConvertSize($attr['WIDTH'],$this->blk[$this->blklvl]['inner_width']);
	if(isset($attr['ALIGN']) && $attr['ALIGN'] != '') $objattr['align'] = $align[strtolower($attr['ALIGN'])];
	if(isset($attr['COLOR']) && $attr['COLOR'] != '') $objattr['color'] = $this->ConvertColor($attr['COLOR']);


	$objattr['type'] = 'hr';
	$objattr['height'] = $objattr['linewidth'] + $objattr['margin_top'] + $objattr['margin_bottom'];
	$e = "\xbb\xa4\xactype=image,objattr=".serialize($objattr)."\xbb\xa4\xac";

	// Clear properties - tidy up
	$properties = array();

		$this->textbuffer[] = array($e,$this->HREF,$this->currentfontstyle,$this->colorarray,$this->currentfontfamily,$this->SUP,$this->SUB,'',$this->strike,$this->outlineparam,$this->spanbgcolorarray,$this->currentfontsize,$this->ReqFontStyle);

	break;




	// *********** FORM ELEMENTS ********************



	// *********** GRAPH  ********************
     case 'JPGRAPH':
	if (!$this->useGraphs) { break; }
	if ($attr['TABLE']) { $gid = strtoupper($attr['TABLE']); }
	else { $gid = '0'; }
	if (!is_array($this->graphs[$gid]) || count($this->graphs[$gid])==0 ) { break; }
	include_once(_MPDF_PATH.'graph.php');
	$this->graphs[$gid]['attr'] = $attr;


	if (isset($this->graphs[$gid]['attr']['WIDTH']) && $this->graphs[$gid]['attr']['WIDTH']) { 
		$this->graphs[$gid]['attr']['cWIDTH']=$this->ConvertSize($this->graphs[$gid]['attr']['WIDTH'],$pgwidth); 
	}	// mm
	if (isset($this->graphs[$gid]['attr']['HEIGHT']) && $this->graphs[$gid]['attr']['HEIGHT']) { 
		$this->graphs[$gid]['attr']['cHEIGHT']=$this->ConvertSize($this->graphs[$gid]['attr']['HEIGHT'],$pgwidth); 
	}

	$graph_img = print_graph($this->graphs[$gid],$this->blk[$this->blklvl]['inner_width']);
	if ($graph_img) { 
		if(isset($attr['ROTATE'])) {
		   if ($attr['ROTATE']==90 || $attr['ROTATE']==-90) {
			$tmpw = $graph_img['w'];
			$graph_img['w']= $graph_img['h'];
			$graph_img['h']= $tmpw;
		   }
		}
		$attr['SRC'] = $graph_img['file']; 
		$attr['WIDTH'] = $graph_img['w']; 
		$attr['HEIGHT'] = $graph_img['h']; 
	}
	else { break; }

	// *********** IMAGE  ********************
    case 'IMG':
	if ($this->progressBar) { $this->UpdateProgressBar(1,'','IMG'); }
	$objattr = array();
		$objattr['margin_top'] = 0;
		$objattr['margin_bottom'] = 0;
		$objattr['margin_left'] = 0;
		$objattr['margin_right'] = 0;
		$objattr['padding_top'] = 0;
		$objattr['padding_bottom'] = 0;
		$objattr['padding_left'] = 0;
		$objattr['padding_right'] = 0;
		$objattr['width'] = 0;
		$objattr['height'] = 0;
		$objattr['border_top']['w'] = 0;
		$objattr['border_bottom']['w'] = 0;
		$objattr['border_left']['w'] = 0;
		$objattr['border_right']['w'] = 0;
	if(isset($attr['SRC']))	{
     		$srcpath = $attr['SRC'];
		$orig_srcpath = $attr['ORIG_SRC'];
		$properties = $this->MergeCSS('',$tag,$attr);
		if(isset($properties ['DISPLAY']) && strtolower($properties ['DISPLAY'])=='none') { 
			return; 
		}
		// VSPACE and HSPACE converted to margins in MergeCSS
		if (isset($properties['MARGIN-TOP'])) { $objattr['margin_top']=$this->ConvertSize($properties['MARGIN-TOP'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }
		if (isset($properties['MARGIN-BOTTOM'])) { $objattr['margin_bottom'] = $this->ConvertSize($properties['MARGIN-BOTTOM'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }
		if (isset($properties['MARGIN-LEFT'])) { $objattr['margin_left'] = $this->ConvertSize($properties['MARGIN-LEFT'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }
		if (isset($properties['MARGIN-RIGHT'])) { $objattr['margin_right'] = $this->ConvertSize($properties['MARGIN-RIGHT'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }

		if (isset($properties['PADDING-TOP'])) { $objattr['padding_top']=$this->ConvertSize($properties['PADDING-TOP'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }
		if (isset($properties['PADDING-BOTTOM'])) { $objattr['padding_bottom'] = $this->ConvertSize($properties['PADDING-BOTTOM'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }
		if (isset($properties['PADDING-LEFT'])) { $objattr['padding_left'] = $this->ConvertSize($properties['PADDING-LEFT'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }
		if (isset($properties['PADDING-RIGHT'])) { $objattr['padding_right'] = $this->ConvertSize($properties['PADDING-RIGHT'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false); }

		if (isset($properties['BORDER-TOP'])) { $objattr['border_top'] = $this->border_details($properties['BORDER-TOP']); }
		if (isset($properties['BORDER-BOTTOM'])) { $objattr['border_bottom'] = $this->border_details($properties['BORDER-BOTTOM']); }
		if (isset($properties['BORDER-LEFT'])) { $objattr['border_left'] = $this->border_details($properties['BORDER-LEFT']); }
		if (isset($properties['BORDER-RIGHT'])) { $objattr['border_right'] = $this->border_details($properties['BORDER-RIGHT']); }

		if (isset($properties['VERTICAL-ALIGN'])) { $objattr['vertical-align'] = $align[strtolower($properties['VERTICAL-ALIGN'])]; }
		$w = 0;
		$h = 0;
		if(isset($properties['WIDTH'])) $w = $this->ConvertSize($properties['WIDTH'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false);
		if(isset($properties['HEIGHT'])) $h = $this->ConvertSize($properties['HEIGHT'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false);

		if(isset($attr['WIDTH'])) $w = $this->ConvertSize($attr['WIDTH'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false);
		if(isset($attr['HEIGHT'])) $h = $this->ConvertSize($attr['HEIGHT'],$this->blk[$this->blklvl]['inner_width'],$this->FontSize,false);
		if (isset($properties['OPACITY']) && $properties['OPACITY'] > 0 && $properties['OPACITY'] <= 1) { $objattr['opacity'] = $properties['OPACITY']; }
		if ($this->HREF) { $objattr['link'] = $this->HREF; }	// ? this isn't used

		$extraheight = $objattr['padding_top'] + $objattr['padding_bottom'] + $objattr['margin_top'] + $objattr['margin_bottom'] + $objattr['border_top']['w'] + $objattr['border_bottom']['w'];
		$extrawidth = $objattr['padding_left'] + $objattr['padding_right'] + $objattr['margin_left'] + $objattr['margin_right'] + $objattr['border_left']['w'] + $objattr['border_right']['w'];

		// Image file
		$info=$this->_getImage($srcpath, true, true, $orig_srcpath);
		if(!$info) {
			$info = $this->_getImage($this->noImageFile);
			if ($info) { 
				$srcpath = $this->noImageFile; 
				$w = ($info['w'] * (25.4/$this->dpi)); 
				$h = ($info['h'] * (25.4/$this->dpi));
			}
		}
		if(!$info) break;

		if(isset($attr['ROTATE'])) {
		   if ($attr['ROTATE']==90 || $attr['ROTATE']==-90) {
			$tmpw = $info['w'];
			$info['w'] = $info['h'];
			$info['h'] = $tmpw;
		   }
		   $objattr['ROTATE'] = $attr['ROTATE'];
		}

		$objattr['file'] = $srcpath;
		//Default width and height calculation if needed
		if($w==0 and $h==0) {
      	      if ($info['type']=='svg') { 
				// SVG units are pixels
				$w = abs($info['w'])/$this->k;
				$h = abs($info['h'])/$this->k;
			}
			else {
				//Put image at default image dpi
				$w=($info['w']/$this->k) * (72/$this->img_dpi);
				$h=($info['h']/$this->k) * (72/$this->img_dpi);
			}
		}
		// IF WIDTH OR HEIGHT SPECIFIED
		if($w==0)  $w=abs($h*$info['w']/$info['h']); 
		if($h==0)	$h=abs($w*$info['h']/$info['w']);

		// Resize to maximum dimensions of page
		$maxWidth = $this->blk[$this->blklvl]['inner_width'];
   		$maxHeight = $this->h - ($this->tMargin + $this->bMargin + 10) ;
		if ($this->fullImageHeight) { $maxHeight = $this->fullImageHeight; }
		if ($w + $extrawidth > $maxWidth ) {
			$w = $maxWidth - $extrawidth;
			$h=abs($w*$info['h']/$info['w']);
		}

		if ($h + $extraheight > $maxHeight ) {
			$h = $maxHeight - $extraheight;
			$w=abs($h*$info['w']/$info['h']);
		}
		$objattr['type'] = 'image';
		$objattr['itype'] = $info['type'];

		$objattr['orig_h'] = $info['h'];
		$objattr['orig_w'] = $info['w'];
		if ($info['type']=='svg') {
			$objattr['wmf_x'] = $info['x'];
			$objattr['wmf_y'] = $info['y'];
		}
		$objattr['height'] = $h + $extraheight;
		$objattr['width'] = $w + $extrawidth;
		$objattr['image_height'] = $h;
		$objattr['image_width'] = $w;

		$e = "\xbb\xa4\xactype=image,objattr=".serialize($objattr)."\xbb\xa4\xac";

		// Clear properties - tidy up
		$properties = array();

			$this->textbuffer[] = array($e,$this->HREF,$this->currentfontstyle,$this->colorarray,$this->currentfontfamily,$this->SUP,$this->SUB,'',$this->strike,$this->outlineparam,$this->spanbgcolorarray,$this->currentfontsize,$this->ReqFontStyle);

	}
	break;





  }//end of switch
}




function CloseTag($tag)
{
	$this->ignorefollowingspaces = false; //Eliminate exceeding left-side spaces
    //Closing tag
    if($tag=='OPTION') { $this->selectoption['ACTIVE'] = false; 	$this->lastoptionaltag = ''; }

    if($tag=='TTS' or $tag=='TTA' or $tag=='TTZ') {
	if ($this->InlineProperties[$tag]) { $this->restoreInlineProperties($this->InlineProperties[$tag]); }
	unset($this->InlineProperties[$tag]);
	$ltag = strtolower($tag);
	$this->$ltag = false;
    }


    if($tag=='FONT' || $tag=='SPAN' || $tag=='CODE' || $tag=='KBD' || $tag=='SAMP' || $tag=='TT' || $tag=='VAR' 
	|| $tag=='INS' || $tag=='STRONG' || $tag=='CITE' || $tag=='SUB' || $tag=='SUP' || $tag=='S' || $tag=='STRIKE' || $tag=='DEL'
	|| $tag=='Q' || $tag=='EM' || $tag=='B' || $tag=='I' || $tag=='U' | $tag=='SMALL' || $tag=='BIG' || $tag=='ACRONYM') {

	if ($tag == 'SPAN') {
		if (isset($this->InlineProperties['SPAN'][$this->spanlvl]) && $this->InlineProperties['SPAN'][$this->spanlvl]) { $this->restoreInlineProperties($this->InlineProperties['SPAN'][$this->spanlvl]); }
		unset($this->InlineProperties['SPAN'][$this->spanlvl]);
		$this->spanlvl--;
	}
	else { 
		if (isset($this->InlineProperties[$tag]) && $this->InlineProperties[$tag]) { $this->restoreInlineProperties($this->InlineProperties[$tag]); }
		unset($this->InlineProperties[$tag]);
	}
    }


    if($tag=='A') {
	$this->HREF=''; 
	if (isset($this->InlineProperties['A'])) { $this->restoreInlineProperties($this->InlineProperties['A']); }
	unset($this->InlineProperties['A']);
    }





	// *********** BLOCKS ********************

    if($tag=='P' || $tag=='DIV' || $tag=='H1' || $tag=='H2' || $tag=='H3' || $tag=='H4' || $tag=='H5' || $tag=='H6' || $tag=='PRE' 
	 || $tag=='FORM' || $tag=='ADDRESS' || $tag=='BLOCKQUOTE' || $tag=='CENTER' || $tag=='DT'  || $tag=='DD'  || $tag=='DL' ) { 

	$this->ignorefollowingspaces = true; //Eliminate exceeding left-side spaces
	$this->blockjustfinished=true;

	$this->lastblockbottommargin = $this->blk[$this->blklvl]['margin_bottom'];


	$this->lastoptionaltag = '';
	$this->divbegin=false;

	$this->linebreakjustfinished=false;

	$this->x = $this->lMargin + $this->blk[$this->blklvl]['outer_left_margin'];


	//Print content
	if ($this->lastblocklevelchange == 1) { $blockstate = 3; }	// Top & bottom margins/padding
	else if ($this->lastblocklevelchange == -1) { $blockstate = 2; }	// Bottom margins/padding only
	else { $blockstate = 0; }
	// called from after e.g. </table> </div> </div> ...    Outputs block margin/border and padding
	if (count($this->textbuffer) && $this->textbuffer[count($this->textbuffer)-1]) {
	  if (substr($this->textbuffer[count($this->textbuffer)-1][0],0,3) != "\xbb\xa4\xac") {	// not special content
	   if ($this->usingCoreFont) {
		$this->textbuffer[count($this->textbuffer)-1][0] = preg_replace('/[ ]+$/', '', $this->textbuffer[count($this->textbuffer)-1][0]);
	   }
	   else {
		$this->textbuffer[count($this->textbuffer)-1][0] = preg_replace('/[ ]+$/u', '', $this->textbuffer[count($this->textbuffer)-1][0]);	   }
	  }
	}
	if (count($this->textbuffer) == 0 && $this->lastblocklevelchange != 0) {
		$this->newFlowingBlock( $this->blk[$this->blklvl]['width'],$this->lineheight,'',false,false,2,true);	// true = newblock
		$this->finishFlowingBlock(true);	// true = END of flowing block
		$this->PaintDivBB('',$blockstate);
	}
	else {
		$this->printbuffer($this->textbuffer,$blockstate); 
	}


	$this->textbuffer=array();

	if ($this->blk[$this->blklvl]['keep_block_together']) {
		$this->printdivbuffer(); 
	}

	if ($this->kwt) {
		$this->kwt_height = $this->y - $this->kwt_y0;
	}


	if($tag=='PRE') { $this->ispre=false; }


	//Reset values
	$this->Reset();

	if ($this->blklvl > 0) {	// ==0 SHOULDN'T HAPPEN - NOT XHTML 
	   if ($this->blk[$this->blklvl]['tag'] == $tag) {
		unset($this->blk[$this->blklvl]);
		$this->blklvl--;
	   }
	   //else { echo $tag; exit; }	// debug - forces error if incorrectly nested html tags
	}

	$this->lastblocklevelchange = -1 ;
	// Reset Inline-type properties
	if (isset($this->blk[$this->blklvl]['InlineProperties'])) { $this->restoreInlineProperties($this->blk[$this->blklvl]['InlineProperties']); }

	$this->x = $this->lMargin + $this->blk[$this->blklvl]['outer_left_margin'];

    }






}






function printbuffer($arrayaux,$blockstate=0,$is_table=false,$is_list=false)
{
// $blockstate = 0;	// NO margins/padding
// $blockstate = 1;	// Top margins/padding only
// $blockstate = 2;	// Bottom margins/padding only
// $blockstate = 3;	// Top & bottom margins/padding
	$this->spanbgcolorarray = array();
	$this->spanbgcolor = false;
	$paint_ht_corr = 0;

    	$bak_y = $this->y;
	$bak_x = $this->x;
	$align = '';
	if (!$is_table && !$is_list) {
		if (isset($this->blk[$this->blklvl]['align']) && $this->blk[$this->blklvl]['align']) { $align = $this->blk[$this->blklvl]['align']; }
		// Block-align is set by e.g. <.. align="center"> Takes priority for this block but not inherited
		if (isset($this->blk[$this->blklvl]['block-align']) && $this->blk[$this->blklvl]['block-align']) { $align = $this->blk[$this->blklvl]['block-align']; }
		$this->divwidth = $this->blk[$this->blklvl]['width'];
	}
	else {
		$align = $this->divalign;
	}
	$oldpage = $this->page;

	// ADDED for Out of Block now done as Flowing Block
	if ($this->divwidth == 0) { 
		$this->divwidth = $this->pgwidth; 
	}

	if (!$is_table && !$is_list) { $this->SetLineHeight($this->FontSizePt,$this->blk[$this->blklvl]['line_height']); }
	$this->divheight = $this->lineheight;
	$old_height = $this->divheight;

    // As a failsafe - if font has been set but not output to page
    $this->SetFont($this->default_font,'',$this->default_font_size,true,true);	// force output to page

    $array_size = count($arrayaux);
    $this->newFlowingBlock( $this->divwidth,$this->divheight,$align,$is_table,$is_list,$blockstate,true);	// true = newblock

	// Added - Otherwise <div><div><p> did not output top margins/padding for 1st/2nd div
    if ($array_size == 0) { $this->finishFlowingBlock(true); }	// true = END of flowing block

    for($i=0;$i < $array_size; $i++)
    {

	// COLS
	$oldcolumn = $this->CurrCol;

      $vetor = $arrayaux[$i];
      if ($i == 0 and $vetor[0] != "\n" and !$this->ispre) {
		$vetor[0] = ltrim($vetor[0]);
	}

	// FIXED TO ALLOW IT TO SHOW '0' 
      if (empty($vetor[0]) && !($vetor[0]==='0') && empty($vetor[7])) { //Ignore empty text and not carrying an internal link
		//Check if it is the last element. If so then finish printing the block
	     	if ($i == ($array_size-1)) { $this->finishFlowingBlock(true); }	// true = END of flowing block
		continue;
	}


      //Activating buffer properties
      if(isset($vetor[11]) and $vetor[11] != '') { 	 // Font Size
		if ($is_table && $this->shrin_k) {
			$this->SetFontSize($vetor[11]/$this->shrin_k,false); 
		}
		else {
			$this->SetFontSize($vetor[11],false); 
		}
	}
      if(isset($vetor[10]) and !empty($vetor[10])) //Background color
      {
		$this->spanbgcolorarray = $vetor[10];
		$this->spanbgcolor = true;
      }
      if(isset($vetor[9]) and !empty($vetor[9])) // Outline parameters
      {
          $cor = $vetor[9]['COLOR'];
          $outlinewidth = $vetor[9]['WIDTH'];
          $this->SetTextOutline($outlinewidth,$cor['R'],$cor['G'],$cor['B']);
          $this->outline_on = true;
      }
      if(isset($vetor[8]) and $vetor[8] === true) // strike-through the text
      {
          $this->strike = true;
      }
      if(isset($vetor[7]) and $vetor[7] != '') // internal link: <a name="anyvalue">
      {
	  if ($this->ColActive) { $ily = $this->y0; } else { $ily = $this->y; }	// use top of columns
        $this->internallink[$vetor[7]] = array("Y"=>$ily,"PAGE"=>$this->page );
        if (empty($vetor[0])) { //Ignore empty text
		//Check if it is the last element. If so then finish printing the block
      	if ($i == ($array_size-1)) { $this->finishFlowingBlock(true); }	// true = END of flowing block
		continue;
	  }
      }
      if(isset($vetor[6]) and $vetor[6] === true) // Subscript 
      {
  		$this->SUB = true;
      }
      if(isset($vetor[5]) and $vetor[5] === true) // Superscript
      {
		$this->SUP = true;
      }
      if(isset($vetor[4]) and $vetor[4] != '') {  // Font Family
		$font = $this->SetFont($vetor[4],$this->FontStyle,0,false); 
	}
      if (!empty($vetor[3])) //Font Color
      {
		$cor = $vetor[3];
		$this->SetTextColor($cor['R'],$cor['G'],$cor['B']);
      }
      if(isset($vetor[2]) and $vetor[2] != '') //Bold,Italic,Underline styles
      {
		$this->SetStyles($vetor[2]);	// mPDF 5.0
      }

      if(isset($vetor[12]) and $vetor[12] != '') { //Requested Bold,Italic,Underline
		$this->ReqFontStyle = $vetor[12];
      }
      if(isset($vetor[1]) and $vetor[1] != '') //LINK
      {
	  
        if (strpos($vetor[1],".") === false && strpos($vetor[1],"@") !== 0) //assuming every external link has a dot indicating extension (e.g: .html .txt .zip www.somewhere.com etc.) 
        {
          //Repeated reference to same anchor?
          while(array_key_exists($vetor[1],$this->internallink)) $vetor[1]="#".$vetor[1];
          $this->internallink[$vetor[1]] = $this->AddLink();
          $vetor[1] = $this->internallink[$vetor[1]];
        }
        $this->HREF = $vetor[1];					// HREF link style set here ******
      }

	// SPECIAL CONTENT - IMAGES & FORM OBJECTS
      //Print-out special content

      if (substr($vetor[0],0,3) == "\xbb\xa4\xac") { //identifier has been identified!
	  
	  $objattr = $this->_getObjAttr($vetor[0]);

			$maxWidth = $this->divwidth - ($this->blk[$this->blklvl]['padding_left'] + $this->blk[$this->blklvl]['border_left']['w'] + $this->blk[$this->blklvl]['padding_right'] + $this->blk[$this->blklvl]['border_right']['w']); 


		list($skipln) = $this->inlineObject($objattr['type'], '', $this->y, $objattr,$this->lMargin, ($this->flowingBlockAttr['contentWidth']/$this->k), $maxWidth, $this->flowingBlockAttr['height'], false, $is_table);
		//  1 -> New line needed because of width
		// -1 -> Will fit width on line but NEW PAGE REQUIRED because of height
		// -2 -> Will not fit on line therefore needs new line but thus NEW PAGE REQUIRED
		$iby = $this->y;
		$oldpage = $this->page;
		$oldcol = $this->CurrCol;
		if (($skipln == 1 || $skipln == -2) && !isset($objattr['float'])) {
            	$this->finishFlowingBlock(false,$objattr['type']);
	           	$this->newFlowingBlock( $this->divwidth,$this->divheight,$align,$is_table,$is_list,$blockstate,false); //false=newblock
		}
		$thispage = $this->page;
		if ($this->CurrCol!=$oldcol) { $changedcol = true; } 
		else { $changedcol=false; }

		// the previous lines can already have triggered page break or column change
		if (!$changedcol && $skipln <0 && $this->AcceptPageBreak() && $thispage==$oldpage) {

			$this->AddPage($this->CurOrientation); 

	  		// Added to correct Images already set on line before page advanced
			// i.e. if second inline image on line is higher than first and forces new page
			if (count($this->objectbuffer)) {
				$yadj = $iby - $this->y;
				foreach($this->objectbuffer AS $ib=>$val) {
					if ($this->objectbuffer[$ib]['OUTER-Y'] ) $this->objectbuffer[$ib]['OUTER-Y'] -= $yadj;
					if ($this->objectbuffer[$ib]['BORDER-Y']) $this->objectbuffer[$ib]['BORDER-Y'] -= $yadj;
					if ($this->objectbuffer[$ib]['INNER-Y']) $this->objectbuffer[$ib]['INNER-Y'] -= $yadj;
				}
			}
		}


	  	// Added to correct for OddEven Margins
   	  	if  ($this->page != $oldpage) {
			if (($this->page-$oldpage) % 2 == 1) { 
				$bak_x += $this->MarginCorrection;
			}
			$oldpage = $this->page;
				$y = $this->tMargin - $paint_ht_corr ;
				$this->oldy = $this->tMargin - $paint_ht_corr ;
				$old_height = 0;
		}
		$this->x = $bak_x;

			$this->WriteFlowingBlock($vetor[0]); 

      }	// END If special content

      else { //THE text
	  if ($this->tableLevel) { $paint_ht_corr = 0; }	// To move the y up when new column/page started if div border needed
	  else { $paint_ht_corr = $this->blk[$this->blklvl]['border_top']['w']; }

        if ($vetor[0] == "\n") { //We are reading a <BR> now turned into newline ("\n")
		if ($this->flowingBlockAttr['content']) {
			$this->finishFlowingBlock(false,'br');
		}
		else if ($is_table) {
			$this->y+= $this->_computeLineheight($this->table_lineheight);
		}
		else if (!$is_table) {
			$this->DivLn($this->lineheight); 
		}
	  	// Added to correct for OddEven Margins
   	  	if  ($this->page != $oldpage) {
			if (($this->page-$oldpage) % 2 == 1) {
				$bak_x += $this->MarginCorrection;
			}
			$oldpage = $this->page;
				$y = $this->tMargin - $paint_ht_corr ;
				$this->oldy = $this->tMargin - $paint_ht_corr ;
				$old_height = 0;
		}
		$this->x = $bak_x;
		$this->newFlowingBlock( $this->divwidth,$this->divheight,$align,$is_table,$is_list,$blockstate,false);	// false = newblock
         }
          else {
		$this->WriteFlowingBlock( $vetor[0]);

		  // Added to correct for OddEven Margins
   		  if  ($this->page != $oldpage) {
			if (($this->page-$oldpage) % 2 == 1) {
				$bak_x += $this->MarginCorrection;
				$this->x = $bak_x;
			}
			$oldpage = $this->page;
				$y = $this->tMargin - $paint_ht_corr ;
				$this->oldy = $this->tMargin - $paint_ht_corr ;
				$old_height = 0;
		  }
	    }


      }

      //Check if it is the last element. If so then finish printing the block
      if ($i == ($array_size-1)) {
		$this->finishFlowingBlock(true);	// true = END of flowing block
		  // Added to correct for OddEven Margins
   		  if  ($this->page != $oldpage) {
			if (($this->page-$oldpage) % 2 == 1) {
				$bak_x += $this->MarginCorrection;
				$this->x = $bak_x;
			}
			$oldpage = $this->page;
				$y = $this->tMargin - $paint_ht_corr ;
				$this->oldy = $this->tMargin - $paint_ht_corr ;
				$old_height = 0;
		  }


	}


	// RESETTING VALUES
	$this->SetTextColor(0);
	$this->SetDrawColor(0);
	$this->SetFillColor(255);
	$this->colorarray = array();
	$this->spanbgcolorarray = array();
	$this->spanbgcolor = false;
	$this->issetcolor = false;
	$this->HREF = '';
	$this->outlineparam = array();
	$this->SetTextOutline(false);
      $this->outline_on = false;
	$this->SUP = false;
	$this->SUB = false;

	$this->strike = false;

	$this->currentfontfamily = '';  
	$this->currentfontsize = '';  
	$this->currentfontstyle = '';  
	if (isset($this->blk[$this->blklvl]['line_height']) && $this->blk[$this->blklvl]['line_height']) {
		$this->SetLineHeight('',$this->blk[$this->blklvl]['line_height']);	// sets default line height
	}
	$this->ResetStyles();	// mPDF 5.0
	$this->toupper = false;
	$this->tolower = false;
	$this->SetDash(); //restore to no dash
	$this->dash_on = false;
	$this->dotted_on = false;

    }//end of for(i=0;i<arraysize;i++)


    // PAINT DIV BORDER	// DISABLED IN COLUMNS AS DOESN'T WORK WHEN BROKEN ACROSS COLS??
    if ((isset($this->blk[$this->blklvl]['border']) || isset($this->blk[$this->blklvl]['bgcolor'])) && $blockstate  && ($this->y != $this->oldy)) {
	$bottom_y = $this->y;	// Does not include Bottom Margin
	if (isset($this->blk[$this->blklvl]['startpage']) && $this->blk[$this->blklvl]['startpage'] != $this->page && $blockstate != 1) {
		$this->PaintDivBB('pagetop',$blockstate);
	}

	else if ($blockstate != 1) {
		$this->PaintDivBB('',$blockstate);
	}
	$this->y = $bottom_y; 
	$this->x = $bak_x;
    }

    // Reset Font
    $this->SetFontSize($this->default_font_size,false); 


}

function _setDashBorder($style, $div, $cp, $side) {
	if ($style == 'dashed' && (($side=='L' || $side=='R') || ($side=='T' && $div != 'pagetop' && !$cp) || ($side=='B' && $div!='pagebottom') )) {
		$dashsize = 2;	// final dash will be this + 1*linewidth
		$dashsizek = 1.5;	// ratio of Dash/Blank
		$this->SetDash($dashsize,($dashsize/$dashsizek)+($this->LineWidth*2));
	}
	else if ($style == 'dotted' || ($side=='T' && ($div == 'pagetop' || $cp)) || ($side=='B' && $div == 'pagebottom')) {
  		//Round join and cap
  		$this->_out("\n".'1 J'."\n".'1 j'."\n");
		$this->SetDash(0.001,($this->LineWidth*3));
	}
}

function _setBorderLine($b, $k=1) {
	$this->SetLineWidth($b['w']/$k);
	$this->SetDrawColor($b['c']['R'],$b['c']['G'],$b['c']['B']);
}

function PaintDivBB($divider='',$blockstate=0,$blvl=0) {
	// Borders & backgrounds are done elsewhere for columns - messes up the repositioning in printcolumnbuffer
	$save_y = $this->y;
	if (!$blvl) { $blvl = $this->blklvl; }

	$x0 = $x1 = $y0 = $y1 = 0; 

	// Added mPDF 3.0 Float DIV

	if (isset($this->blk[$blvl]['x0'])) { $x0 = $this->blk[$blvl]['x0']; }	// left
	if (isset($this->blk[$blvl]['y1'])) { $y1 = $this->blk[$blvl]['y1']; }	// bottom

	// Added mPDF 3.0 Float DIV - ensures backgrounds/borders are drawn to bottom of page
	if ($y1==0) { 
		if ($divider=='pagebottom') { $y1 = $this->h-$this->bMargin; }
		else { $y1 = $this->y; }
	}


	if (isset($this->blk[$blvl]['startpage']) && $this->blk[$blvl]['startpage'] != $this->page) { $continuingpage = true; } else { $continuingpage = false; } 

	if (isset($this->blk[$blvl]['y0'])) { $y0 = $this->blk[$blvl]['y0']; }
	$h = $y1 - $y0;
	$w = $this->blk[$blvl]['width'];
	$x1 = $x0 + $w;

	// Set border-widths as used here
	$border_top = $this->blk[$blvl]['border_top']['w'];
	$border_bottom = $this->blk[$blvl]['border_bottom']['w'];
	$border_left = $this->blk[$blvl]['border_left']['w'];
	$border_right = $this->blk[$blvl]['border_right']['w'];
	if (!$this->blk[$blvl]['border_top'] || $divider == 'pagetop' || $continuingpage) {
		$border_top = 0;
	}
	if (!$this->blk[$blvl]['border_bottom'] || $blockstate == 1 || $divider == 'pagebottom') { 
		$border_bottom = 0;
	}

		$brTL_H = 0;
		$brTL_V = 0;
		$brTR_H = 0;
		$brTR_V = 0;
		$brBL_H = 0;
		$brBL_V = 0;
		$brBR_H = 0;
		$brBR_V = 0;

	$brset = false; 

		// BORDERS
		if (isset($this->blk[$blvl]['y0']) && $this->blk[$blvl]['y0']) { $y0 = $this->blk[$blvl]['y0']; }
		$h = $y1 - $y0;
		$w = $this->blk[$blvl]['width'];

		//if ($this->blk[$blvl]['border_top']) {
		// Reinstate line above for dotted line divider when block border crosses a page
		if ($this->blk[$blvl]['border_top'] && $divider != 'pagetop' && !$continuingpage) {
			$tbd = $this->blk[$blvl]['border_top'];
			if (isset($tbd['s']) && $tbd['s']) {
				$this->_setBorderLine($tbd);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],$divider,$continuingpage,'T'); }
					$this->_out(sprintf('%.3f %.3f m ',($x0 + $w - ($border_top/2))*$this->k, ($this->h-($y0 + ($border_top/2)))*$this->k));
					$this->_out(sprintf('%.3f %.3f l ',($x0 + ($border_top/2))*$this->k, ($this->h-($y0 + ($border_top/2)))*$this->k));
				$this->_out('S');

				// Reset Corners and Dash off
  				$this->_out("\n".'2 J'."\n".'2 j'."\n");
				$this->SetDash(); 
			}
		}
		//if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1) { 
		// Reinstate line above for dotted line divider when block border crosses a page
		if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1 && $divider != 'pagebottom') { 
			$tbd = $this->blk[$blvl]['border_bottom'];
			if (isset($tbd['s']) && $tbd['s']) {
				$this->_setBorderLine($tbd);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],$divider,$continuingpage,'B'); }
					$this->_out(sprintf('%.3f %.3f m ',($x0 + ($border_bottom/2))*$this->k, ($this->h-($y0 + $h - ($border_bottom/2)))*$this->k));
					$this->_out(sprintf('%.3f %.3f l ',($x0 + $w - ($border_bottom/2) )*$this->k, ($this->h-($y0 + $h - ($border_bottom/2)))*$this->k));
				$this->_out('S');

				// Reset Corners and Dash off
  				$this->_out("\n".'2 J'."\n".'2 j'."\n");
				$this->SetDash(); 
			}
		}
		if ($this->blk[$blvl]['border_left']) { 
			$tbd = $this->blk[$blvl]['border_left'];
			if (isset($tbd['s']) && $tbd['s']) {
				$this->_setBorderLine($tbd);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],$divider,$continuingpage,'L'); }
					$this->_out(sprintf('%.3f %.3f m ',($x0 + ($border_left/2))*$this->k, ($this->h-($y0 + ($border_left/2)))*$this->k));
					$this->_out(sprintf('%.3f %.3f l ',($x0 + ($border_left/2))*$this->k, ($this->h-($y0 + $h - ($border_left/2)) )*$this->k));
				$this->_out('S');

				// Reset Corners and Dash off
  				$this->_out("\n".'2 J'."\n".'2 j'."\n");
				$this->SetDash(); 
			}
		}
		if ($this->blk[$blvl]['border_right']) { 
			$tbd = $this->blk[$blvl]['border_right'];
			if (isset($tbd['s']) && $tbd['s']) {
				$this->_setBorderLine($tbd);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],$divider,$continuingpage,'R'); }
					$this->_out(sprintf('%.3f %.3f m ',($x0 + $w - ($border_right/2))*$this->k, ($this->h-($y0 + $h - ($border_right/2)))*$this->k));
					$this->_out(sprintf('%.3f %.3f l ',($x0 + $w - ($border_right/2))*$this->k, ($this->h-($y0 + ($border_right/2)) )*$this->k));
				$this->_out('S');

				// Reset Corners and Dash off
  				$this->_out("\n".'2 J'."\n".'2 j'."\n");
				$this->SetDash(); 
			}
		}

		if (!$brset) {	// not if border-radius used
			$tbcol = array(255,255,255);
			for($l=0; $l <= $blvl; $l++) {
				if ($this->blk[$l]['bgcolor']) {
					$tbcol = array($this->blk[$l]['bgcolorarray']['R'],$this->blk[$l]['bgcolorarray']['G'],$this->blk[$l]['bgcolorarray']['B']);
				}
			}
		}
		if ($this->blk[$blvl]['border_top'] && $divider != 'pagetop' && !$continuingpage) {
			$tbd = $this->blk[$blvl]['border_top'];
			if (isset($tbd['s']) && $tbd['s']) {
				if (!$brset && $tbd['style']=='double') {
					$this->SetLineWidth($tbd['w']/3);
					$this->SetDrawColor($tbcol[0],$tbcol[1],$tbcol[2]);
					$this->_out(sprintf('%.3f %.3f m %.3f %.3f l S', ($x0 + $w - ($border_top/2))*$this->k, ($this->h-($y0 + ($border_top/2)))*$this->k, ($x0 + ($border_top/2))*$this->k, ($this->h-($y0 + ($border_top/2)))*$this->k ));
				}
			}
		}
		if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1 && $divider != 'pagebottom') { 
			$tbd = $this->blk[$blvl]['border_bottom'];
			if (isset($tbd['s']) && $tbd['s']) {
				if (!$brset && $tbd['style']=='double') {
					$this->SetLineWidth($tbd['w']/3);
					$this->SetDrawColor($tbcol[0],$tbcol[1],$tbcol[2]);
					$this->_out(sprintf('%.3f %.3f m %.3f %.3f l S', ($x0 + ($border_bottom/2))*$this->k, ($this->h-($y0 + $h - ($border_bottom/2)))*$this->k, ($x0 + $w - ($border_bottom/2) )*$this->k, ($this->h-($y0 + $h - ($border_bottom/2)))*$this->k ));
				}
			}
		}
		if ($this->blk[$blvl]['border_left']) { 
			$tbd = $this->blk[$blvl]['border_left'];
			if (isset($tbd['s']) && $tbd['s']) {
				if (!$brset && $tbd['style']=='double') {
					$this->SetLineWidth($tbd['w']/3);
					$this->SetDrawColor($tbcol[0],$tbcol[1],$tbcol[2]);
					$this->_out(sprintf('%.3f %.3f m %.3f %.3f l S', ($x0 + ($border_left/2))*$this->k, ($this->h-($y0 + ($border_left/2)))*$this->k, ($x0 + ($border_left/2))*$this->k, ($this->h-($y0 + $h - ($border_left/2)) )*$this->k));
				}
			}
		}
		if ($this->blk[$blvl]['border_right']) { 
			$tbd = $this->blk[$blvl]['border_right'];
			if (isset($tbd['s']) && $tbd['s']) {
				if (!$brset && $tbd['style']=='double') {
					$this->SetLineWidth($tbd['w']/3);
					$this->SetDrawColor($tbcol[0],$tbcol[1],$tbcol[2]);
					$this->_out(sprintf('%.3f %.3f m %.3f %.3f l S', ($x0 + $w - ($border_right/2))*$this->k, ($this->h-($y0 + $h - ($border_right/2)))*$this->k, ($x0 + $w - ($border_right/2))*$this->k, ($this->h-($y0 + ($border_right/2)) )*$this->k));
				}
			}
		}


		$this->SetDash(); 
	$this->y = $save_y; 


	// BACKGROUNDS are disabled in columns/kbt/headers - messes up the repositioning in printcolumnbuffer
	if ($this->ColActive || $this->kwt || $this->keep_block_together) { return ; }

	$bgx0 = $x0;
	$bgx1 = $x1;
	$bgy0 = $y0;
	$bgy1 = $y1;

		$brbgTL_H = $brTL_H;
		$brbgTL_V = $brTL_V;
		$brbgTR_H = $brTR_H;
		$brbgTR_V = $brTR_V;
		$brbgBL_H = $brBL_H;
		$brbgBL_V = $brBL_V;
		$brbgBR_H = $brBR_H;
		$brbgBR_V = $brBR_V;

	// Set clipping path
	$s = ' q 0 w ';	// Line width=0
	$s .= sprintf('%.3f %.3f m ', ($bgx0+$brbgTL_H )*$this->k, ($this->h-$bgy0)*$this->k);	// start point TL before the arc
	$s .= sprintf('%.3f %.3f l ', ($bgx0)*$this->k, ($this->h-($bgy1-$brbgBL_V ))*$this->k);	// line to BL
	$s .= sprintf('%.3f %.3f l ', ($bgx1-$brbgBR_H )*$this->k, ($this->h-($bgy1))*$this->k);	// line to BR
	$s .= sprintf('%.3f %.3f l ', ($bgx1)*$this->k, ($this->h-($bgy0+$brbgTR_V))*$this->k);	// line to TR
	$s .= sprintf('%.3f %.3f l ', ($bgx0+$brbgTL_H )*$this->k, ($this->h-$bgy0)*$this->k);	// line to TL
	$s .= ' W n ';	// Ends path no-op & Sets the clipping path

	if ($this->blk[$blvl]['bgcolor']) { 
		$this->pageBackgrounds[$blvl][] = array('x'=>$x0, 'y'=>$y0, 'w'=>$w, 'h'=>$h, 'col'=>$this->blk[$blvl]['bgcolorarray'], 'clippath'=>$s);
	}


	// Added mPDF 3.0 Float DIV
	$this->blk[$blvl]['bb_painted'][$this->page] = true;

}




function PaintDivLnBorder($state=0,$blvl=0,$h) {
	// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom

	$this->ColDetails[$this->CurrCol]['bottom_margin'] = $this->y + $h; 

	$save_y = $this->y;

	$w = $this->blk[$blvl]['width'];
	$x0 = $this->x;				// left
	$y0 = $this->y;				// top
	$x1 = $this->x + $w;			// bottom
	$y1 = $this->y + $h;			// bottom

		if ($this->blk[$blvl]['border_top'] && ($state==1 || $state==3)) {
			$tbd = $this->blk[$blvl]['border_top'];
			if (isset($tbd['s']) && $tbd['s']) {
				$this->_setBorderLine($tbd);
				$this->y = $y0 + ($tbd['w']/2);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],'',$continuingpage,'T'); }
				$this->Line($x0 + ($tbd['w']/2) , $this->y , $x0 + $w - ($tbd['w']/2), $this->y);
				$this->y += $tbd['w'];
				// Reset Corners and Dash off
  				$this->_out('2 J 2 j');
				$this->SetDash(); 

			}
		}

		if ($this->blk[$blvl]['border_left']) { 
			$tbd = $this->blk[$blvl]['border_left'];
			if (isset($tbd['s']) && $tbd['s']) {
				$this->_setBorderLine($tbd);
				$this->y = $y0 + ($tbd['w']/2);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],'',$continuingpage,'L'); }
				$this->Line($x0 + ($tbd['w']/2), $this->y, $x0 + ($tbd['w']/2), $y0 + $h -($tbd['w']/2));
				$this->y += $tbd['w'];
				// Reset Corners and Dash off
  				$this->_out('2 J 2 j');
				$this->SetDash(); 

			}
		}
		if ($this->blk[$blvl]['border_right']) { 
			$tbd = $this->blk[$blvl]['border_right'];
			if (isset($tbd['s']) && $tbd['s']) {
				$this->_setBorderLine($tbd);
			 	$this->y = $y0 + ($tbd['w']/2);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],'',$continuingpage,'R'); }
				$this->Line($x0 + $w - ($tbd['w']/2), $this->y, $x0 + $w - ($tbd['w']/2), $y0 + $h - ($tbd['w']/2));
				$this->y += $tbd['w'];
				// Reset Corners and Dash off
  				$this->_out('2 J 2 j');
				$this->SetDash(); 

			}
		}
		if ($this->blk[$blvl]['border_bottom'] && $state > 1) { 
			$tbd = $this->blk[$blvl]['border_bottom'];
			if (isset($tbd['s']) && $tbd['s']) {
				$this->_setBorderLine($tbd);
				$this->y = $y0 + $h - ($tbd['w']/2);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],'',$continuingpage,'B'); }
				$this->Line($x0 + ($tbd['w']/2) , $this->y, $x0 + $w - ($tbd['w']/2), $this->y);
				$this->y += $tbd['w'];
				// Reset Corners and Dash off
  				$this->_out('2 J 2 j');
				$this->SetDash(); 

			}
		}
		$this->SetDash(); 


	$this->y = $save_y; 
}


function PaintImgBorder($objattr,$is_table) {
	// Borders are disabled in columns - messes up the repositioning in printcolumnbuffer
	if ($is_table) { $k = $this->shrin_k; } else { $k = 1; }
		$h = $objattr['BORDER-HEIGHT'];
		$w = $objattr['BORDER-WIDTH'];
		$x0 = $objattr['BORDER-X'];
		$y0 = $objattr['BORDER-Y'];

		// BORDERS
		if ($objattr['border_top']) { 
			$tbd = $objattr['border_top'];
			if ($tbd['s']) {
				$this->_setBorderLine($tbd,$k);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],'','','T'); }
				$this->Line($x0, $y0, $x0 + $w, $y0);
				// Reset Corners and Dash off
  				$this->_out('2 J 2 j');
				$this->SetDash(); 

			}
		}
		if ($objattr['border_left']) { 
			$tbd = $objattr['border_left'];
			if ($tbd['s']) {
				$this->_setBorderLine($tbd,$k);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],'','','L'); }
				$this->Line($x0, $y0, $x0, $y0 + $h);
				// Reset Corners and Dash off
  				$this->_out('2 J 2 j');
				$this->SetDash(); 

			}
		}
		if ($objattr['border_right']) { 
			$tbd = $objattr['border_right'];
			if ($tbd['s']) {
				$this->_setBorderLine($tbd,$k);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],'','','R'); }
				$this->Line($x0 + $w, $y0, $x0 + $w, $y0 + $h);
				// Reset Corners and Dash off
  				$this->_out('2 J 2 j');
				$this->SetDash(); 

			}
		}
		if ($objattr['border_bottom']) { 
			$tbd = $objattr['border_bottom'];
			if ($tbd['s']) {
				$this->_setBorderLine($tbd,$k);
				if ($tbd['style']=='dotted' || $tbd['style']=='dashed') { $this->_setDashBorder($tbd['style'],'','','B'); }
				$this->Line($x0, $y0 + $h, $x0 + $w, $y0 + $h);
				// Reset Corners and Dash off
  				$this->_out('2 J 2 j');
				$this->SetDash(); 

			}
		}
		$this->SetDash(); 

}





function Reset()
{
	$this->SetTextColor(0);
	$this->colorarray = array();
	$this->issetcolor = false;

	$this->SetDrawColor(0);

	$this->SetFillColor(255);
	$this->spanbgcolorarray = array();
	$this->spanbgcolor = false;

	$this->ResetStyles();	// mPDF 5.0

	$this->HREF = '';
	$this->outlineparam = array();
      $this->outline_on = false;
	$this->SetTextOutline(false);

	$this->SUP = false;
	$this->SUB = false;
	$this->strike = false;

	$this->SetFont($this->default_font,'',0,false);
	$this->SetFontSize($this->default_font_size,false);

	$this->currentfontfamily = '';  
	$this->currentfontsize = '';  

	if (isset($this->blk[$this->blklvl]['line_height']) && $this->blk[$this->blklvl]['line_height']) {
		$this->SetLineHeight('',$this->blk[$this->blklvl]['line_height']);	// sets default line height
	}

	$this->toupper = false;
	$this->tolower = false;
	$this->SetDash(); //restore to no dash
	$this->dash_on = false;
	$this->dotted_on = false;
	$this->divwidth = 0;
	$this->divheight = 0;
	$this->divalign = $this->defaultAlign;
	$this->divrevert = false;
	$this->oldy = -1;

	$bodystyle = array();
	if (isset($this->CSS['BODY']['FONT-STYLE'])) { $bodystyle['FONT-STYLE'] = $this->CSS['BODY']['FONT-STYLE']; }
	if (isset($this->CSS['BODY']['FONT-WEIGHT'])) { $bodystyle['FONT-WEIGHT'] = $this->CSS['BODY']['FONT-WEIGHT']; }
	if (isset($this->CSS['BODY']['COLOR'])) { $bodystyle['COLOR'] = $this->CSS['BODY']['COLOR']; }
	if (isset($bodystyle)) { $this->setCSS($bodystyle,'BLOCK','BODY'); }

}

function ReadMetaTags($html)
{
	// changes anykey=anyvalue to anykey="anyvalue" (only do this when this happens inside tags)
	$regexp = '/ (\\w+?)=([^\\s>"]+)/si'; 
 	$html = preg_replace($regexp," \$1=\"\$2\"",$html);

	if (preg_match('/<title>(.*?)<\/title>/si',$html,$m)) {
		$this->SetTitle($m[1]); 
	}

  preg_match_all('/<meta [^>]*?(name|content)="([^>]*?)" [^>]*?(name|content)="([^>]*?)".*?>/si',$html,$aux);
  $firstattr = $aux[1];
  $secondattr = $aux[3];
  for( $i = 0 ; $i < count($aux[0]) ; $i++)
  {

     $name = ( strtoupper($firstattr[$i]) == "NAME" )? strtoupper($aux[2][$i]) : strtoupper($aux[4][$i]);
     $content = ( strtoupper($firstattr[$i]) == "CONTENT" )? $aux[2][$i] : $aux[4][$i];
     switch($name)
     {
       case "KEYWORDS": $this->SetKeywords($content); break;
       case "AUTHOR": $this->SetAuthor($content); break;
       case "DESCRIPTION": $this->SetSubject($content); break;
     }
  }
}


function ReadCharset($html)
{
	// Charset conversion
	if ($this->allow_charset_conversion) {
	   if (preg_match('/<head.*charset=([^\'\"\s]*).*<\/head>/si',$html,$m)) {
		if (strtoupper($m[1]) != 'UTF-8') {
			$this->charset_in = strtoupper($m[1]); 
		}
	   }
	}

}

//////////////////
/// CSS parser ///
//////////////////
//////////////////
/// CSS parser ///
//////////////////
//////////////////
/// CSS parser ///
//////////////////

function ReadDefaultCSS($CSSstr) {
    $CSS = array();
    $CSSstr = preg_replace('|/\*.*?\*/|s',' ',$CSSstr);
    $CSSstr = preg_replace('/[\s\n\r\t\f]/s',' ',$CSSstr);

    $CSSstr = preg_replace('/(<\!\-\-|\-\->)/s',' ',$CSSstr);
    if ($CSSstr ) {
	preg_match_all('/(.*?)\{(.*?)\}/',$CSSstr,$styles);
	for($i=0; $i < count($styles[1]) ; $i++)  {
	 	$stylestr= trim($styles[2][$i]);
		$stylearr = explode(';',$stylestr);
		foreach($stylearr AS $sta) {
		   if (trim($sta)) {
			// Changed to allow style="background: url('http://www.bpm1.com/bg.jpg')"
			list($property,$value) = explode(':',$sta,2);
			$property = trim($property);
			$value = preg_replace('/\s*!important/i','',$value);
			$value = trim($value);
			if ($property && ($value || $value==='0')) {
	  			$classproperties[strtoupper($property)] = $value;
			}
		   }
		}
		$classproperties = $this->fixCSS($classproperties);
		$tagstr = strtoupper(trim($styles[1][$i]));
		$tagarr = explode(',',$tagstr);
		foreach($tagarr AS $tg) {
		  $tags = preg_split('/\s+/',trim($tg));
		  $level = count($tags);
		  if ($level == 1) {		// e.g. p or .class or #id or p.class or p#id
		     $t = trim($tags[0]);
		     if ($t) {
			$tag = '';
			if (preg_match('/^('.$this->allowedCSStags.')$/',$t)) { $tag= $t; }
			if ($this->CSS[$tag] && $tag) { $CSS[$tag] = $this->array_merge_recursive_unique($CSS[$tag], $classproperties); }
			else if ($tag) { $CSS[$tag] = $classproperties; }
		     }
		  }
		}
  		$properties = array();
  		$values = array();
  		$classproperties = array();
	}

    } // end of if
    return $CSS;
}




function ReadCSS($html) {
//
// This supports:  .class {...} / #id { .... }
// p {...}  h1[-h6] {...}  a {...}  table {...}   thead {...}  th {...}  td {...}  hr {...}
// body {...} sets default font and fontsize
// It supports some cascaded CSS e.g. div.topic table.type1 td
// Does not support non-block level e.g. a#hover { ... }

	preg_match_all('/<style[^>]*media=["\']([^"\'>]*)["\'].*?<\/style>/is',$html,$m);
	for($i=0; $i<count($m[0]); $i++) {
		if ($this->CSSselectMedia && !preg_match('/('.trim($this->CSSselectMedia).'|all)/i',$m[1][$i])) { 
			$html = preg_replace('/'.preg_quote($m[0][$i],'/').'/','',$html);
		}
	}
	preg_match_all('/<link[^>]*media=["\']([^"\'>]*)["\'].*?>/is',$html,$m);
	for($i=0; $i<count($m[0]); $i++) {
		if ($this->CSSselectMedia && !preg_match('/('.trim($this->CSSselectMedia).'|all)/i',$m[1][$i])) { 
			$html = preg_replace('/'.preg_quote($m[0][$i],'/').'/','',$html);
		}
	}


	// Remove Comment tags <!--  --> inside CSS as <style> in HTML document
	preg_match_all('/<style.*?>(.*?)<\/style>/si',$html,$m);
	if (count($m[1])) { 
		for($i=0;$i<count($m[1]);$i++) {
			// Remove comment tags 
			$sub = preg_replace('/(<\!\-\-|\-\->)/s',' ',$m[1][$i]);
			$html = preg_replace('/'.preg_quote($m[1][$i], '/').'/si', $sub, $html); 
		}
	}

	$html = preg_replace('/<!--mpdf/i','',$html);
	$html = preg_replace('/mpdf-->/i','',$html);
	$html = preg_replace('/<\!\-\-.*?\-\->/s',' ',$html);

	$match = 0; // no match for instance
	$regexp = ''; // This helps debugging: showing what is the REAL string being processed
	$CSSext = array(); 

	//CSS inside external files
	$regexp = '/<link[^>]*rel=["\']stylesheet["\'][^>]*href=["\']([^>"\']*)["\'].*?>/si'; // EDIT mPDF 4.0
	$x = preg_match_all($regexp,$html,$cxt);
	if ($x) { 
		$match += $x; 
		$CSSext = $cxt[1];
	}

	$regexp = '/<link[^>]*href=["\']([^>"\']*)["\'][^>]*?rel=["\']stylesheet["\'].*?>/si';  // EDIT mPDF 4.0
	$x = preg_match_all($regexp,$html,$cxt);
	if ($x) { 
		$match += $x; 
		$CSSext = array_merge($CSSext,$cxt[1]);
	}

	// look for @import stylesheets
	$regexp = '/@import url\([\'\"]{0,1}([^\)]*?\.css)[\'\"]{0,1}\)/si'; // EDIT mPDF 4.0
	$x = preg_match_all($regexp,$html,$cxt);
	if ($x) { 
		$match += $x; 
		$CSSext = array_merge($CSSext,$cxt[1]);
	}

	// look for @import without the url()
	$regexp = '/@import [\'\"]{0,1}([^;]*?\.css)[\'\"]{0,1}/si';
	$x = preg_match_all($regexp,$html,$cxt);
	if ($x) { 
		$match += $x; 
		$CSSext = array_merge($CSSext,$cxt[1]);
	}

  $ind = 0;
  $CSSstr = '';

  // Edited mPDF v1.4
  if (!is_array($this->cascadeCSS)) $this->cascadeCSS = array();

    while($match){
	$path = $CSSext[$ind];
	$this->GetFullPath($path); 
	$CSSextblock = $this->_get_file($path);
	if ($CSSextblock) {
		// look for embedded @import stylesheets in other stylesheets
		// and fix url paths (including background-images) relative to stylesheet
		$regexpem = '/@import url\([\'\"]{0,1}(.*?\.css)[\'\"]{0,1}\)/si';
		$xem = preg_match_all($regexpem,$CSSextblock,$cxtem);
		$cssBasePath = preg_replace('/\/[^\/]*$/','',$path) . '/';
		if ($xem) { 
		   foreach($cxtem[1] AS $cxtembedded) {
			// path is relative to original stlyesheet!!
			$this->GetFullPath($cxtembedded, $cssBasePath );
			$match++; 
			$CSSext[] = $cxtembedded;
		   }
		}
		$regexpem = '/(background[^;]*url\s*\(\s*[\'\"]{0,1})([^\)\'\"]*)([\'\"]{0,1}\s*\))/si';
		$xem = preg_match_all($regexpem,$CSSextblock,$cxtem);
		if ($xem) { 
		   for ($i=0;$i<count($cxtem[0]);$i++) {
			// path is relative to original stlyesheet!!
			$embedded = $cxtem[2][$i];
			$this->GetFullPath($embedded, $cssBasePath );
			$CSSextblock = preg_replace('/'.preg_quote($cxtem[0][$i],'/').'/', ($cxtem[1][$i].$embedded.$cxtem[3][$i]), $CSSextblock);
		   }
		}
		$CSSstr .= ' '.$CSSextblock;
	}
	$match--;
	$ind++;
    } //end of match

    $match = 0; // reset value, if needed
	// CSS as <style> in HTML document
    $regexp = '/<style.*?>(.*?)<\/style>/si'; 
    $match = preg_match_all($regexp,$html,$CSSblock);
    if ($match) {
		$tmpCSSstr = implode(' ',$CSSblock[1]);
		$regexpem = '/(background[^;]*url\s*\(\s*[\'\"]{0,1})([^\)\'\"]*)([\'\"]{0,1}\s*\))/si';
		$xem = preg_match_all($regexpem,$tmpCSSstr ,$cxtem);
		if ($xem) { 
		   for ($i=0;$i<count($cxtem[0]);$i++) {
			$embedded = $cxtem[2][$i];
			$this->GetFullPath($embedded);
			$tmpCSSstr = preg_replace('/'.preg_quote($cxtem[0][$i],'/').'/', ($cxtem[1][$i].$embedded.$cxtem[3][$i]), $tmpCSSstr );
		   }
		}
		$CSSstr .= ' '.$tmpCSSstr;
    }
    // Remove comments
    $CSSstr = preg_replace('|/\*.*?\*/|s',' ',$CSSstr);
    $CSSstr = preg_replace('/[\s\n\r\t\f]/s',' ',$CSSstr);

    if (preg_match('/@media/',$CSSstr)) { 
	preg_match_all('/@media(.*?)\{(([^\{\}]*\{[^\{\}]*\})+)\s*\}/is',$CSSstr,$m);
	for($i=0; $i<count($m[0]); $i++) {
		if ($this->CSSselectMedia && !preg_match('/('.trim($this->CSSselectMedia).'|all)/i',$m[1][$i])) { 
			$CSSstr = preg_replace('/'.preg_quote($m[0][$i],'/').'/','',$CSSstr);
		}
		else {
			$CSSstr = preg_replace('/'.preg_quote($m[0][$i],'/').'/',' '.$m[2][$i].' ',$CSSstr);
		}
	}
    }

    $CSSstr = preg_replace('/(<\!\-\-|\-\->)/s',' ',$CSSstr);
    if ($CSSstr ) {
	preg_match_all('/(.*?)\{(.*?)\}/',$CSSstr,$styles);
	for($i=0; $i < count($styles[1]) ; $i++)  {
		// SET array e.g. $classproperties['COLOR'] = '#ffffff';
	 	$stylestr= trim($styles[2][$i]);
		$stylearr = explode(';',$stylestr);
		foreach($stylearr AS $sta) {
		   if (trim($sta)) { 
			// Changed to allow style="background: url('http://www.bpm1.com/bg.jpg')"
			list($property,$value) = explode(':',$sta,2);
			$property = trim($property);
			$value = preg_replace('/\s*!important/i','',$value);
			$value = trim($value);
			if ($property && ($value || $value==='0')) {
	  			$classproperties[strtoupper($property)] = $value;
			}
		   }
		}
		$classproperties = $this->fixCSS($classproperties);
		$tagstr = strtoupper(trim($styles[1][$i]));
		$tagarr = explode(',',$tagstr);
		$pageselectors = false;	// used to turn on $this->mirrorMargins
		foreach($tagarr AS $tg) {
		  $tags = preg_split('/\s+/',trim($tg));
		  $level = count($tags);
		  $t = '';
		  $t2 = '';
		  $t3 = '';
		  if (trim($tags[0])=='@PAGE') {
			if (isset($tags[0])) { $t = trim($tags[0]); }
			if (isset($tags[1])) { $t2 = trim($tags[1]); }
			if (isset($tags[2])) { $t3 = trim($tags[2]); }
			$tag = '';
			if ($level==1) { $tag = $t; }
			else if ($level==2 && preg_match('/^[:](.*)$/',$t2,$m)) { 
				$tag = $t.'>>PSEUDO>>'.$m[1]; 
				if ($m[1]=='LEFT' || $m[1]=='RIGHT') { $pageselectors = true; }	// used to turn on $this->mirrorMargins 
			}
			else if ($level==2) { $tag = $t.'>>NAMED>>'.$t2; }
			else if ($level==3 && preg_match('/^[:](.*)$/',$t3,$m)) { 
				$tag = $t.'>>NAMED>>'.$t2.'>>PSEUDO>>'.$m[1]; 
				if ($m[1]=='LEFT' || $m[1]=='RIGHT') { $pageselectors = true; }	// used to turn on $this->mirrorMargins
			}
			if (isset($this->CSS[$tag]) && $tag) { $this->CSS[$tag] = $this->array_merge_recursive_unique($this->CSS[$tag], $classproperties); }
			else if ($tag) { $this->CSS[$tag] = $classproperties; }
		  }

		  else if ($level == 1) {		// e.g. p or .class or #id or p.class or p#id
		     if (isset($tags[0])) { $t = trim($tags[0]); }
		     if ($t) {
			$tag = '';
			if (preg_match('/^[.](.*)$/',$t,$m)) { $tag = 'CLASS>>'.$m[1]; }
			else if (preg_match('/^[#](.*)$/',$t,$m)) { $tag = 'ID>>'.$m[1]; }
			else if (preg_match('/^('.$this->allowedCSStags.')[.](.*)$/',$t,$m)) { $tag = $m[1].'>>CLASS>>'.$m[2]; }
			else if (preg_match('/^('.$this->allowedCSStags.')[#](.*)$/',$t,$m)) { $tag = $m[1].'>>ID>>'.$m[2]; }
			else if (preg_match('/^('.$this->allowedCSStags.')$/',$t)) { $tag= $t; }

			if (isset($this->CSS[$tag]) && $tag) { $this->CSS[$tag] = $this->array_merge_recursive_unique($this->CSS[$tag], $classproperties); }
			else if ($tag) { $this->CSS[$tag] = $classproperties; }
		     }
		  }
		  else {
		   $tmp = array();
		   for($n=0;$n<$level;$n++) {
		     if (isset($tags[$n])) { $t = trim($tags[$n]); }
		     else { $t = ''; }
		     if ($t) {
			$tag = '';
			if (preg_match('/^[.](.*)$/',$t,$m)) { $tag = 'CLASS>>'.$m[1]; }
			else if (preg_match('/^[#](.*)$/',$t,$m)) { $tag = 'ID>>'.$m[1]; }
			else if (preg_match('/^('.$this->allowedCSStags.')[.](.*)$/',$t,$m)) { $tag = $m[1].'>>CLASS>>'.$m[2]; }
			else if (preg_match('/^('.$this->allowedCSStags.')[#](.*)$/',$t,$m)) { $tag = $m[1].'>>ID>>'.$m[2]; }
			else if (preg_match('/^('.$this->allowedCSStags.')$/',$t)) { $tag= $t; }

			if ($tag) $tmp[] = $tag;
			else { break; }
		    }
		   }
		   
		   if ($tag) {
			   $x = &$this->cascadeCSS; 
			   foreach($tmp AS $tp) { $x = &$x[$tp]; }
			   $x = $this->array_merge_recursive_unique($x, $classproperties); 
			   $x['depth'] = $level;
		   }
		  }
		}
		if ($pageselectors) { $this->mirrorMargins = true; }
  		$properties = array();
  		$values = array();
  		$classproperties = array();
	}

    } // end of if
    //Remove CSS (tags and content), if any
    $regexp = '/<style.*?>(.*?)<\/style>/si'; // it can be <style> or <style type="txt/css"> 
    $html = preg_replace($regexp,'',$html);
//print_r($this->CSS); exit;
//print_r($this->cascadeCSS); exit;
    return $html;
}

function readInlineCSS($html)
{
	//Fix incomplete CSS code
	$size = strlen($html)-1;
	if (substr($html,$size,1) != ';') $html .= ';';
	//Make CSS[Name-of-the-class] = array(key => value)
	$regexp = '|\\s*?(\\S+?):(.+?);|i';
	preg_match_all( $regexp, $html, $styleinfo);
	$properties = $styleinfo[1];
	$values = $styleinfo[2];
	//Array-properties and Array-values must have the SAME SIZE!
	$classproperties = array();
	for($i = 0; $i < count($properties) ; $i++) $classproperties[strtoupper($properties[$i])] = trim($values[$i]);
	return $this->fixCSS($classproperties);
}



function setCSS($arrayaux,$type='',$tag='')	// type= INLINE | BLOCK // tag= BODY
{
	if (!is_array($arrayaux)) return; //Removes PHP Warning
	// Set font size first so that e.g. MARGIN 0.83em works on font size for this element
	if (isset($arrayaux['FONT-SIZE'])) {
		$v = $arrayaux['FONT-SIZE'];
		if(is_numeric($v[0])) {
			$mmsize = $this->ConvertSize($v,$this->FontSize);
			$this->SetFontSize( $mmsize*($this->k),false ); //Get size in points (pt)
		}
		else{
  			$v = strtoupper($v);
			if (isset($this->fontsizes[$v])) { 
				$this->SetFontSize( $this->fontsizes[$v]* $this->default_font_size,false);
			}
		}
		if ($tag == 'BODY') { $this->SetDefaultFontSize($this->FontSizePt); }
	}


	if ($this->useLang && !$this->usingCoreFont) { 
	   if (isset($arrayaux['LANG']) && $arrayaux['LANG'] && $arrayaux['LANG'] != $this->default_lang && ((strlen($arrayaux['LANG']) == 5 && $arrayaux['LANG'] != 'UTF-8') || strlen($arrayaux['LANG']) == 2)) {
		list ($coreSuitable,$mpdf_pdf_unifonts,$mpdf_directionality,$mpdf_jSpacing) = GetLangOpts($arrayaux['LANG'], $this->useAdobeCJK);
		if ($mpdf_pdf_unifonts) { $this->RestrictUnicodeFonts($mpdf_pdf_unifonts); }
		else { $this->RestrictUnicodeFonts($this->default_available_fonts ); }
		if ($mpdf_directionality == 'rtl') { $this->biDirectional = true; }
		if ($tag == 'BODY') {
			$this->jSpacing = $mpdf_jSpacing;
			$this->SetDirectionality($mpdf_directionality);
			$this->currentLang = $arrayaux['LANG'];
			$this->default_lang = $arrayaux['LANG'];
			$this->default_jSpacing = $mpdf_jSpacing;
			if ($mpdf_pdf_unifonts) { $this->default_available_fonts = $mpdf_pdf_unifonts; }
			$this->default_dir = $mpdf_directionality;
		}
		else if ($type == 'BLOCK') {
			$this->jSpacing = $mpdf_jSpacing;
		}
		else {	// INLINE
			if ($this->disableMultilingualJustify && $mpdf_jSpacing != $this->jSpacing && $this->blk[$this->blklvl]['align']=="J") {
          			$this->blk[$this->blklvl]['align']="";
			}
		}
	   }
	   else { 
		$this->RestrictUnicodeFonts($this->default_available_fonts ); 
		$this->jSpacing = $this->default_jSpacing;
	   }
	}



	// FOR INLINE and BLOCK OR 'BODY'
	if (isset($arrayaux['FONT-FAMILY'])) {
		$v = $arrayaux['FONT-FAMILY'];
		//If it is a font list, get all font types
		$aux_fontlist = explode(",",$v);


			$found = 0;
			foreach($aux_fontlist AS $f) {
				$fonttype = trim($f);
				$fonttype = preg_replace('/["\']*(.*?)["\']*/','\\1',$fonttype);
				$fonttype = preg_replace('/ /','',$fonttype);
				$v = strtolower(trim($fonttype));
				if (isset($this->fonttrans[$v]) && $this->fonttrans[$v]) { $v = $this->fonttrans[$v]; }
				if ((!$this->usingCoreFont && in_array($v,$this->available_unifonts)) || 
					($this->usingCoreFont && in_array($v,array('courier','times','helvetica','arial'))) || 
					in_array($v, array('sjis','uhc','big5','gb'))) { 
					$fonttype = $v; 
					$found = 1;
					break;
				}
			}
			if (!$found) {
			   foreach($aux_fontlist AS $f) {
				$fonttype = trim($f);
				$fonttype = preg_replace('/["\']*(.*?)["\']*/','\\1',$fonttype);
				$fonttype = preg_replace('/ /','',$fonttype);
				$v = strtolower(trim($fonttype));
				if (isset($this->fonttrans[$v]) && $this->fonttrans[$v]) { $v = $this->fonttrans[$v]; }
				if (in_array($v,$this->sans_fonts) || in_array($v,$this->serif_fonts) || in_array($v,$this->mono_fonts) ) { 
					$fonttype = $v; 
					break;
				}
			   }
			}

		if ($tag == 'BODY') { 
			$this->SetDefaultFont($fonttype); 
		}
		$this->SetFont($fonttype,$this->currentfontstyle,0,false);
	}
	else { 
		$this->SetFont($this->currentfontfamily,$this->currentfontstyle,0,false); 
	}

   foreach($arrayaux as $k => $v) {
	if ($type != 'INLINE' && $tag != 'BODY') {
	  switch($k){
		// BORDERS
		case 'BORDER-TOP':
			$this->blk[$this->blklvl]['border_top'] = $this->border_details($v);
			if ($this->blk[$this->blklvl]['border_top']['s']) { $this->blk[$this->blklvl]['border'] = 1; }
			break;
		case 'BORDER-BOTTOM':
			$this->blk[$this->blklvl]['border_bottom'] = $this->border_details($v);
			if ($this->blk[$this->blklvl]['border_bottom']['s']) { $this->blk[$this->blklvl]['border'] = 1; }
			break;
		case 'BORDER-LEFT':
			$this->blk[$this->blklvl]['border_left'] = $this->border_details($v);
			if ($this->blk[$this->blklvl]['border_left']['s']) { $this->blk[$this->blklvl]['border'] = 1; }
			break;
		case 'BORDER-RIGHT':
			$this->blk[$this->blklvl]['border_right'] = $this->border_details($v);
			if ($this->blk[$this->blklvl]['border_right']['s']) { $this->blk[$this->blklvl]['border'] = 1; }
			break;

		// PADDING
		case 'PADDING-TOP':
			$this->blk[$this->blklvl]['padding_top'] = $this->ConvertSize($v,$this->blk[$this->blklvl-1]['inner_width'],$this->FontSize,false);
			break;
		case 'PADDING-BOTTOM':
			$this->blk[$this->blklvl]['padding_bottom'] = $this->ConvertSize($v,$this->blk[$this->blklvl-1]['inner_width'],$this->FontSize,false);
			break;
		case 'PADDING-LEFT':
			$this->blk[$this->blklvl]['padding_left'] = $this->ConvertSize($v,$this->blk[$this->blklvl-1]['inner_width'],$this->FontSize,false);
			break;
		case 'PADDING-RIGHT':
			$this->blk[$this->blklvl]['padding_right'] = $this->ConvertSize($v,$this->blk[$this->blklvl-1]['inner_width'],$this->FontSize,false);
			break;

		// MARGINS
		case 'MARGIN-TOP':
			$tmp = $this->ConvertSize($v,$this->blk[$this->blklvl-1]['inner_width'],$this->FontSize,false);
			if (isset($this->blk[$this->blklvl]['lastbottommargin'])) {
				if ($tmp > $this->blk[$this->blklvl]['lastbottommargin']) {
					$tmp -= $this->blk[$this->blklvl]['lastbottommargin'];
				}
				else { 
					$tmp = 0;
				}
			}
			$this->blk[$this->blklvl]['margin_top'] = $tmp;
			break;
		case 'MARGIN-BOTTOM':
			$this->blk[$this->blklvl]['margin_bottom'] = $this->ConvertSize($v,$this->blk[$this->blklvl-1]['inner_width'],$this->FontSize,false);
			break;
		case 'MARGIN-LEFT':
			$this->blk[$this->blklvl]['margin_left'] = $this->ConvertSize($v,$this->blk[$this->blklvl-1]['inner_width'],$this->FontSize,false);
			break;
		case 'MARGIN-RIGHT':
			$this->blk[$this->blklvl]['margin_right'] = $this->ConvertSize($v,$this->blk[$this->blklvl-1]['inner_width'],$this->FontSize,false);
			break;


		case 'BACKGROUND-CLIP':
			if (strtoupper($v) == 'PADDING-BOX') { $this->blk[$this->blklvl]['background_clip'] = 'padding-box'; }
			break;

		case 'PAGE-BREAK-AFTER':
			if (strtoupper($v) == 'AVOID') { $this->blk[$this->blklvl]['page_break_after_avoid'] = true; }
			break;

		case 'WIDTH':
			if (strtoupper($v) != 'AUTO') { 
				$this->blk[$this->blklvl]['css_set_width'] = $this->ConvertSize($v,$this->blk[$this->blklvl-1]['inner_width'],$this->FontSize,false); 
			}
			break;

		case 'TEXT-INDENT':
			// Left as raw value (may include 1% or 2em)
			$this->blk[$this->blklvl]['text_indent'] = $v;
			break;

	  }//end of switch($k)
	}


	if ($type != 'INLINE') {	// includes BODY tag
	  switch($k){

		case 'MARGIN-COLLAPSE':	// Custom tag to collapse margins at top and bottom of page
			if (strtoupper($v) == 'COLLAPSE') { $this->blk[$this->blklvl]['margin_collapse'] = true; }
			break;

		case 'LINE-HEIGHT':
			$this->blk[$this->blklvl]['line_height'] = $this->fixLineheight($v);
			if (!$this->blk[$this->blklvl]['line_height'] ) { $this->blk[$this->blklvl]['line_height'] = $this->normalLineheight; }
			break;

		case 'TEXT-ALIGN': //left right center justify
			switch (strtoupper($v)) {
				case 'LEFT': 
                        $this->blk[$this->blklvl]['align']="L";
                        break;
				case 'CENTER': 
                        $this->blk[$this->blklvl]['align']="C";
                        break;
				case 'RIGHT': 
                        $this->blk[$this->blklvl]['align']="R";
                        break;
				case 'JUSTIFY': 
                        $this->blk[$this->blklvl]['align']="J";
                        break;
			}
			break;

	  }//end of switch($k)
	}

	// mPDF 5.0
	// FOR INLINE ONLY
	if ($type == 'INLINE') {
	  switch($k){
		case 'DISPLAY':	// Custom tag to collapse margins at top and bottom of page
			if (strtoupper($v) == 'NONE') { $this->inlineDisplayOff = true; }
			break;
	  }//end of switch($k)
	}


	// FOR INLINE and BLOCK
	  switch($k){
		case 'TEXT-ALIGN': //left right center justify
			if (strtoupper($v) == 'NOJUSTIFY' && $this->blk[$this->blklvl]['align']=="J") {
                        $this->blk[$this->blklvl]['align']="";
			}
			break;
		// bgcolor only - to stay consistent with original html2fpdf
		case 'BACKGROUND': 
		case 'BACKGROUND-COLOR': 
			$cor = $this->ConvertColor($v);
			if ($cor) { 
			   
			   if ($tag  == 'BODY') {
				$this->bodyBackgroundColor = $cor;
			   }
			   else if ($type == 'INLINE') {
				$this->spanbgcolorarray = $cor;
				$this->spanbgcolor = true;
			   }
			   else {
				$this->blk[$this->blklvl]['bgcolorarray'] = $cor;
				$this->blk[$this->blklvl]['bgcolor'] = true;
			   }
			}
			else if ($type != 'INLINE') {
  		  		if ($this->ColActive || $this->keep_block_together) { 
					$this->blk[$this->blklvl]['bgcolorarray'] = $this->blk[$this->blklvl-1]['bgcolorarray'] ;
					$this->blk[$this->blklvl]['bgcolor'] = $this->blk[$this->blklvl-1]['bgcolor'] ;
				}
			}
			break;



		case 'FONT-STYLE': // italic normal oblique
			switch (strtoupper($v)) {
				case 'ITALIC': 
				case 'OBLIQUE': 
            			$this->SetStyle('I',true);
					break;
				case 'NORMAL': 
            			$this->SetStyle('I',false);
					break;
			}
			break;

		case 'FONT-WEIGHT': // normal bold //Does not support: bolder, lighter, 100..900(step value=100)
			switch (strtoupper($v))	{
				case 'BOLD': 
            			$this->SetStyle('B',true);
					break;
				case 'NORMAL': 
            			$this->SetStyle('B',false);
					break;
			}
			break;

		case 'VERTICAL-ALIGN': //super and sub only dealt with here e.g. <SUB> and <SUP>
			switch (strtoupper($v)) {
				case 'SUPER': 
                        $this->SUP=true;
                        break;
				case 'SUB': 
                        $this->SUB=true;
                        break;
			}
			break;

		case 'TEXT-DECORATION': // none underline line-through (strikeout) //Does not support: overline, blink
			if (stristr($v,'LINE-THROUGH')) {
					$this->strike = true;
			}
			if (stristr($v,'UNDERLINE')) {
            			$this->SetStyle('U',true);
			}
			break;

		case 'FONT-VARIANT': // mPDF 5.0
			switch (strtoupper($v)) {
				case 'SMALL-CAPS': 
					$this->SetStyle('S',true);
					break;
				case 'NORMAL': 
					$this->SetStyle('S',false);
					break;
			}
			break;

		case 'TEXT-TRANSFORM': // none uppercase lowercase //Does not support: capitalize
			switch (strtoupper($v)) { //Not working 100%
				case 'UPPERCASE':
					$this->toupper=true;
					break;
				case 'LOWERCASE':
 					$this->tolower=true;
					break;
				case 'NONE': break;
			}
			break;

		case 'OUTLINE-WIDTH': 
			switch(strtoupper($v)) {
				case 'THIN': $v = '0.03em'; break;
				case 'MEDIUM': $v = '0.05em'; break;
				case 'THICK': $v = '0.07em'; break;
			}
			$this->outlineparam['WIDTH'] = $this->ConvertSize($v,$this->blk[$this->blklvl]['inner_width'],$this->FontSize);
			break;

		case 'OUTLINE-COLOR': 
			if (strtoupper($v) == 'INVERT') {
			   if ($this->colorarray) {
				$cor = $this->colorarray;
				$this->outlineparam['COLOR'] = array('R'=> (255-$cor['R']), 'G'=> (255-$cor['G']), 'B'=> (255-$cor['B']));
			   }
			   else {
				$this->outlineparam['COLOR'] = array('R'=> 255, 'G'=> 255, 'B'=> 255);
			   }
			}
			else { 
		  	  $cor = $this->ConvertColor($v);
			  if ($cor) { $this->outlineparam['COLOR'] = $cor ; }	  
			}
			break;

		case 'COLOR': // font color
		  $cor = $this->ConvertColor($v);
			if ($cor) { 
				$this->colorarray = $cor;
				$this->SetTextColor($cor['R'],$cor['G'],$cor['B']);
				$this->issetcolor = true;
			}
		  break;

		case 'DIR': 
			$this->biDirectional = true;
			break;

	  }//end of switch($k)


   }//end of foreach
}

function SetStyle($tag,$enable) {
	$this->$tag=$enable;
	$style='';
	foreach(array('B','I','U','S') as $s) {	// mPDF 5.0
		if($this->$s) {
			$style.=$s;
		}
	}
	$this->currentfontstyle=$style;
	$this->SetFont('',$style,0,false);
}

// Set multiple styles at one $str e.g. "BIS"
function SetStylesArray($arr) {	// mPDF 5.0
	$style='';
	foreach(array('B','I','U','S') as $s) {
	  if (isset($arr[$s])) {
		if ($arr[$s]) {
			$this->$s = true;
			$style.=$s;
		}
		else { $this->$s = false; }
	  }
	  else if ($this->$s) {	$style.=$s; }
	}
	$this->currentfontstyle=$style;
	$this->SetFont('',$style,0,false);
}

// Set multiple styles at one $str e.g. "BIS"
function SetStyles($str) {	// mPDF 5.0
	$style='';
	foreach(array('B','I','U','S') as $s) {
		if (strpos($str,$s) !== false) {
			$this->$s = true;
			$style.=$s;
		}
		else { $this->$s = false; }
	}
	$this->currentfontstyle=$style;
	$this->SetFont('',$style,0,false);
}

function ResetStyles() {	// mPDF 5.0
	foreach(array('B','I','U','S') as $s) {
		$this->$s = false;
	}
	$this->currentfontstyle='';
	$this->SetFont('','',0,false);
}


function DisableTags($str='')
{
  if ($str == '') //enable all tags
  {
    //Insert new supported tags in the long string below.
	///////////////////////////////////////////////////////
	// Added custom tags <indexentry>
    $this->enabledtags = "<span><s><strike><del><bdo><big><small><ins><cite><acronym><font><sup><sub><b><u><i><a><strong><em><code><samp><tt><kbd><var><q><table><thead><tfoot><tbody><tr><th><td><ol><ul><li><dl><dt><dd><form><input><select><textarea><option><div><p><h1><h2><h3><h4><h5><h6><pre><center><blockquote><address><hr><img><br><indexentry><indexinsert><bookmark><watermarktext><watermarkimage><tts><ttz><tta><column_break><columnbreak><newcolumn><newpage><page_break><pagebreak><formfeed><columns><toc><tocentry><tocpagebreak><pageheader><pagefooter><setpageheader><setpagefooter><sethtmlpageheader><sethtmlpagefooter><annotation><template><jpgraph><barcode><dottab>";
  }
  else
  {
    $str = explode(",",$str);
    foreach($str as $v) $this->enabledtags = str_replace(trim($v),'',$this->enabledtags);
  }
}





function setBorder(&$var, $flag, $set = true) {
	$flag = intval($flag);
	if ($set) { $set = true; }
	$var = intval($var);
	$var = $set ? ($var | $flag) : ($var & ~$flag);
}
function issetBorder($var, $flag) {
	$flag = intval($flag);
	$var = intval($var);
	return (($var & $flag) == $flag);
}


function _table2cellBorder(&$tableb, &$cbdb, &$cellb, $bval) {
	if ($tableb && $tableb['w'] > $cbdb['w']) {
		$cbdb = $tableb;
		$this->setBorder($cellb, $bval); 
	}
	else if ($tableb && $tableb['w'] == $cbdb['w'] 
		&& array_search($tableb['style'],$this->borderstyles) > array_search($cbdb['style'],$this->borderstyles)) {
		$cbdb = $tableb;
		$this->setBorder($cellb, $bval); 
	}
}

// FIX BORDERS ********************************************
function _fixTableBorders(&$table){

	if (!$table['borders_separate'] && $table['border_details']['L']['w']) {
		$table['max_cell_border_width']['L'] = $table['border_details']['L']['w']; 
	}
	if (!$table['borders_separate'] && $table['border_details']['R']['w']) {
		$table['max_cell_border_width']['R'] = $table['border_details']['R']['w']; 
	}
	if (!$table['borders_separate'] && $table['border_details']['T']['w']) {
		$table['max_cell_border_width']['T'] = $table['border_details']['T']['w']; 
	}
	if (!$table['borders_separate'] && $table['border_details']['B']['w']) {
		$table['max_cell_border_width']['B'] = $table['border_details']['B']['w']; 
	}
	if ($this->simpleTables) { return; }
	$cells = &$table['cells'];
	$numcols = $table['nc'];
	$numrows = $table['nr'];

	for( $i = 0 ; $i < $numrows ; $i++ ) { //Rows
	  for( $j = 0 ; $j < $numcols ; $j++ ) { //Columns
		if (isset($cells[$i][$j]) && $cells[$i][$j]) {
			$cell = &$cells[$i][$j];
			if ($this->packTableData) {
				$cbord = $this->_unpackCellBorder($cell['borderbin']);
			}
			else {
				$cbord = &$cells[$i][$j];
			}

  			if (!$cbord['border'] && isset($table['border']) && $table['border'] && $this->table_border_attr_set) {
				$cbord['border'] = $table['border'];
				$cbord['border_details'] = $table['border_details'];
			}

			if (isset($cell['colspan']) && $cell['colspan']>1) { $ccolsp = $cell['colspan']; }
			else { $ccolsp = 1; }
			if (isset($cell['rowspan']) && $cell['rowspan']>1) { $crowsp = $cell['rowspan']; }
			else { $crowsp = 1; }

			$cbord['border_details']['cellposdom'] = ((($i+1)/$numrows) / 10000 ) + ((($j+1)/$numcols) / 10 );
			// Inherit Cell border from Table border
			if ($this->table_border_css_set && !$table['borders_separate']) {
				if ($i == 0) {
				  $this->_table2cellBorder($table['border_details']['T'], $cbord['border_details']['T'], $cbord['border'], _BORDER_TOP);
				}
				if ($i == ($numrows-1) || ($i+$crowsp) == ($numrows) ) {
				  $this->_table2cellBorder($table['border_details']['B'], $cbord['border_details']['B'], $cbord['border'], _BORDER_BOTTOM);
				}
				if ($j == 0) {
				  $this->_table2cellBorder($table['border_details']['L'], $cbord['border_details']['L'], $cbord['border'], _BORDER_LEFT);
				}
				if ($j == ($numcols-1) || ($j+$ccolsp) == ($numcols) ) {
				  $this->_table2cellBorder($table['border_details']['R'], $cbord['border_details']['R'], $cbord['border'], _BORDER_RIGHT);
				}
			}


			if ($this->packTableData) { $cell['borderbin'] = $this->_packCellBorder($cbord); }
			unset($cbord );
			unset($cell );
		}
	  }
	}
	unset($cell );
}
// END FIX BORDERS ************************************************************************************

function _tableWrite(&$table){
	$level = $table['level'];
	$levelid = $table['levelid'];

	$cells = &$table['cells'];
	$numcols = $table['nc'];
	$numrows = $table['nr'];


	// TABLE TOP MARGIN
	if ($table['margin']['T']) {
	   if (!$this->table_rotate && $level==1) {
		$this->DivLn($table['margin']['T'],$this->blklvl,true,1); 	// collapsible
	   }
	   else {
		$this->y += ($table['margin']['T']);
	   }
	}

	// Advance down page by half width of top border
	if ($table['borders_separate']) { 
		$adv = $table['padding']['T'] + $table['border_details']['T']['w'] + $table['border_spacing_V']/2; 
	}
	else { 
		$adv = $table['max_cell_border_width']['T']/2; 
	}
	if (!$this->table_rotate && $level==1) { $this->DivLn($adv); }
	else { $this->y += $adv; }


	if ($level==1) {
		$this->x = $this->lMargin  + $this->blk[$this->blklvl]['outer_left_margin'] + $this->blk[$this->blklvl]['padding_left'] + $this->blk[$this->blklvl]['border_left']['w'];
		$x0 = $this->x; 
		$y0 = $this->y;
		$right = $x0 + $this->blk[$this->blklvl]['inner_width'];
		$outerfilled = $this->y;	// Keep track of how far down the outer DIV bgcolor is painted (NB rowspans)
		$this->outerfilled = $this->y;
	}
	else {
		$x0 = $this->x; 
		$y0 = $this->y;
		$right = $x0 + $table['w'];
	}

	if ($this->table_rotate) {
		$temppgwidth = $this->tbrot_maxw;
		$this->PageBreakTrigger = $pagetrigger = $y0 + ($this->blk[$this->blklvl]['inner_width']);
	   if ($level==1) {
		$this->tbrot_y0 = $this->y - $adv - $table['margin']['T'] ;
		$this->tbrot_x0 = $this->x;
		$this->tbrot_w = $table['w'];
		if ($table['borders_separate']) { $this->tbrot_h = $table['margin']['T'] + $table['padding']['T'] + $table['border_details']['T']['w'] + $table['border_spacing_V']/2; }
		else { $this->tbrot_h = $table['margin']['T'] + $table['padding']['T'] + $table['max_cell_border_width']['T']; }
	   }
	}
	else {
		$this->PageBreakTrigger = $pagetrigger = ($this->h - $this->bMargin);
	   	if ($level==1) {
			$temppgwidth = $this->blk[$this->blklvl]['inner_width'];
	   		if (isset($table['a']) and ($table['w'] < $this->blk[$this->blklvl]['inner_width'])) {
				if ($table['a']=='C') { $x0 += ((($right-$x0) - $table['w'])/2); }
				else if ($table['a']=='R') { $x0 = $right - $table['w']; }
			}
	   	}
		else {
			$temppgwidth = $table['w'];
		}
	}

	if ($table['overflow']=='hidden' && $level==1 && !$this->table_rotate && !$this->ColActive) {
		//Bounding rectangle to clip
		$this->tableClipPath = sprintf('q %.3f %.3f %.3f %.3f re W n',$x0*$this->k,$this->h*$this->k,$this->blk[$this->blklvl]['inner_width']*$this->k,-$this->h*$this->k);
		$this->_out($this->tableClipPath);
	}
	else { $this->tableClipPath = ''; }


	if ($table['borders_separate']) { $indent = $table['margin']['L'] + $table['border_details']['L']['w'] + $table['padding']['L'] + $table['border_spacing_H']/2; }
	else { $indent = $table['margin']['L'] + $table['max_cell_border_width']['L']/2; }
	$x0 += $indent;

	$returny = 0;
	$tableheader = array();
	$tablefooter = array();
	$tablefooterrowheight = 0;
	$footery = 0;

	// mPD 3.0 Set the Page & Column where table starts
	if (($this->mirrorMargins) && (($this->page)%2==0)) {	// EVEN
		$tablestartpage = 'EVEN'; 
	}
	else if (($this->mirrorMargins) && (($this->page)%2==1)) {	// ODD
		$tablestartpage = 'ODD'; 
	}
	else { $tablestartpage = ''; }
	if ($this->ColActive) { $tablestartcolumn = $this->CurrCol; }
	else { $tablestartcolumn = ''; }

	$y = $h = 0;

	for( $i = 0 ; $i < $numrows ; $i++ ) { //Rows
	  if ($this->progressBar) { $this->UpdateProgressBar(7,intval(30 + ($i*40/$numrows)),' '); }
	  if (isset($table['is_tfoot'][$i]) && $table['is_tfoot'][$i] && $level==1) { 
		$tablefooterrowheight += $table['hr'][$i]; 
	  	for( $j = 0 ; $j < $numcols ; $j++ ) { //Columns
			if (isset($cells[$i][$j]) && $cells[$i][$j]) {
				$cell = &$cells[$i][$j];
				list($x,$w) = $this->_tableGetWidth($table, $i, $j);
				list($y,$h) = $this->_tableGetHeight($table, $i, $j);  
				$x += $x0;
				$y += $y0;

				//Get info of tfoot ==>> table footer
				$tablefooter[$i][$j]['x'] = $x;
				$tablefooter[$i][$j]['y'] = $y;
				$tablefooter[$i][$j]['h'] = $h;
				$tablefooter[$i][$j]['w'] = $w;
				$tablefooter[$i][$j]['text'] = $cell['text'];
				if (isset($cell['textbuffer'])) { $tablefooter[$i][$j]['textbuffer'] = $cell['textbuffer']; }
				else { $tablefooter[$i][$j]['textbuffer'] = ''; }
				$tablefooter[$i][$j]['a'] = $cell['a'];
				$tablefooter[$i][$j]['R'] = $cell['R'];
				$tablefooter[$i][$j]['va'] = $cell['va'];
				$tablefooter[$i][$j]['mih'] = $cell['mih'];
				//CELL FILL BGCOLOR
				if (!$this->simpleTables){
			 		if ($this->packTableData) {
						$c = $this->_unpackCellBorder($cell['borderbin']);
						$tablefooter[$i][$j]['border'] = $c['border'];
						$tablefooter[$i][$j]['border_details'] = $c['border_details'];
					}
			 		else {
						$tablefooter[$i][$j]['border'] = $cell['border'];
						$tablefooter[$i][$j]['border_details'] = $cell['border_details'];
					}
				}
				else if ($this->simpleTables){
					$tablefooter[$i][$j]['border'] = $table['simple']['border'];
					$tablefooter[$i][$j]['border_details'] = $table['simple']['border_details'];
				}
				$fill = isset($cell['bgcolor']) ? $cell['bgcolor'] : 0;
				$tablefooter[$i][$j]['bgcolor'] = $fill;
				$tablefooter[$i][$j]['padding'] = $cell['padding'];
				$tablefooter[$i][$j]['rowspan'] = $cell['rowspan'];
				$tablefooter[$i][$j]['colspan'] = $cell['colspan'];
			}
		}
	  }
	}

	//Draw Table Contents and Borders
	for( $i = 0 ; $i < $numrows ; $i++ ) { //Rows

	  // Get Maximum row/cell height in row - including rowspan>1 + 1 overlapping
	  $maxrowheight = 0;
	  for( $j = 0 ; $j < $numcols ; $j++ ) { //Columns
		list($y,$h) = $this->_tableGetHeight($table, $i, $j);
		$maxrowheight = max($maxrowheight,$h);
	  }

	  $skippage = false;
	  $newpagestarted = false;
	  for( $j = 0 ; $j < $numcols ; $j++ ) { //Columns
		if (isset($cells[$i][$j]) && $cells[$i][$j]) {
			$cell = &$cells[$i][$j];

			list($x,$w) = $this->_tableGetWidth($table, $i, $j);
			list($y,$h) = $this->_tableGetHeight($table, $i, $j);
			$x += $x0;
			$y += $y0;
			$y -= $returny;
			if ($table['borders_separate']) { 
			  
			  if (!empty($tablefooter) || $i == ($numrows-1) || (isset($cell['rowspan']) && ($i+$cell['rowspan']) == $numrows)  || (!isset($cell['rowspan']) && ($i+1) == $numrows) ) {
				$extra = $table['padding']['B'] + $table['border_details']['B']['w'] + $table['border_spacing_V']/2; 
				//$extra = $table['margin']['B'] + $table['padding']['B'] + $table['border_details']['B']['w'] + $table['border_spacing_V']/2; 
			  }
			  else {
				$extra = $table['border_spacing_V']/2; 
			  }
			}
	  		else { $extra = $table['max_cell_border_width']['B']/2; }

			if ($j==0 && ((($y + $maxrowheight + $extra ) > ($pagetrigger+0.001)) || (($this->keepColumns || !$this->ColActive) && !empty($tablefooter) && ($y + $maxrowheight + $tablefooterrowheight + $extra) > $pagetrigger) && ($i < ($numrows - $this->tableheadernrows))) && ($y0 >0 || $x0 > 0) && !$this->InFooter && $this->autoPageBreak ) {	// mPDF 5.0
				if (!$skippage) {
		      		if (($this->keepColumns || !$this->ColActive) && !empty($tablefooter) && $i > 0 ) { 
						$this->y = $y;
						$ya = $this->y;
						$this->TableHeaderFooter($tablefooter,$tablestartpage,$tablestartcolumn,'F');
						if ($this->table_rotate) {
							$this->tbrot_h += $this->y - $ya ;
						}
					}
					$y -= $y0;
					$returny += $y;

					$oldcolumn = $this->CurrCol;
					if ($this->AcceptPageBreak()) {
	  					$newpagestarted = true;
						$this->y = $y + $y0;

						// Move down to account for border-spacing or 
						// extra half border width in case page breaks in middle
						if($i>0 && !$this->table_rotate && $level==1 && !$this->ColActive) {
							if ($table['borders_separate']) { $adv = $table['border_spacing_V']/2; }
							else { 
								$maxbwbottom = 0;
								for( $ctj = 0 ; $ctj < $numcols ; $ctj++ ) {
									if (isset($cells[$i][$ctj]) && $cells[$i][$ctj]) {
										if (!$this->simpleTables){
			 								if ($this->packTableData) {
			 	   								list($bt,$br,$bb,$bl) = $this->_getBorderWidths($cells[$i][$ctj]['borderbin']);
											}
											else {
												$bt = $cells[$i][$ctj]['border_details']['T']['w'];
											}
											$maxbwbottom = max($maxbwbottom , $bt); 
										}
										else if ($this->simpleTables){
											$maxbwbottom = max($maxbwbottom , $table['simple']['border_details']['T']['w']); 
										}
									}
								}
								$adv = $maxbwbottom /2;
							}
							$this->y += $adv;
						}

						// Rotated table split over pages - needs this->y for borders/backgrounds
						if($i>0 && $this->table_rotate && $level==1) {
							$this->y = $y0 + $this->tbrot_w;
						}

						if ($this->tableClipPath ) { $this->_out("Q"); }

						$this->AddPage($this->CurOrientation);

						if ($this->tableClipPath ) { $this->_out($this->tableClipPath); }

						// Added to correct for OddEven Margins
						$x=$x +$this->MarginCorrection;
						$x0=$x0 +$this->MarginCorrection;


						// Move down to account for half of top border-spacing or 
						// extra half border width in case page was broken in middle
						if($i>0 && !$this->table_rotate && $level==1 && !$this->usetableheader) {
							if ($table['borders_separate']) { $adv = $table['border_spacing_V']/2; }
							else { 
								$maxbwtop = 0;
								for( $ctj = 0 ; $ctj < $numcols ; $ctj++ ) {
									if (isset($cells[$i][$ctj]) && $cells[$i][$ctj]) {
										if (!$this->simpleTables){
			 								if ($this->packTableData) {
			 	   								list($bt,$br,$bb,$bl) = $this->_getBorderWidths($cells[$i][$ctj]['borderbin']);
											}
											else {
												$bt = $cells[$i][$ctj]['border_details']['T']['w'];
											}
											$maxbwtop = max($maxbwtop, $bt); 
										}
										else if ($this->simpleTables){
											$maxbwtop = max($maxbwtop, $table['simple']['border_details']['T']['w']); 
										}
									}
								}
								$adv = $maxbwtop /2;
							}
							$this->y += $adv;
						}


						if ($this->table_rotate) {
							$this->tbrot_x0 = $this->lMargin  + $this->blk[$this->blklvl]['outer_left_margin'] + $this->blk[$this->blklvl]['padding_left'] + $this->blk[$this->blklvl]['border_left']['w'];
							if ($table['borders_separate']) { $this->tbrot_h = $table['margin']['T'] + $table['padding']['T'] + $table['border_details']['T']['w'] + $table['border_spacing_V']/2; }
							else { $this->tbrot_h = $table['margin']['T'] + $table['max_cell_border_width']['T'] ; }
							$this->tbrot_y0 = $this->y;
							$pagetrigger = $y0 + ($this->blk[$this->blklvl]['inner_width']);
						}
						else {
							$pagetrigger = $this->PageBreakTrigger;
						}

						if ($this->kwt_saved && $level==1) {
							$this->kwt_moved = true;
						}

						// Disable Table header repeat if Keep Block together
             				if ($this->usetableheader && !$this->keep_block_together && !empty($tableheader)) { 
							$ya = $this->y;
							$this->TableHeaderFooter($tableheader,$tablestartpage,$tablestartcolumn,'H');  
							if ($this->table_rotate) {
								$this->tbrot_h = $this->y - $ya ;
							}
						}

						else if ($i==0 && !$this->keep_block_together && !$this->table_rotate && $level==1 && !$this->ColActive) {
							// Advance down page
							if ($table['borders_separate']) { $adv = $table['border_spacing_V']/2 + $table['border_details']['T']['w'] + $table['padding']['T'];  }
							else { $adv = $table['max_cell_border_width']['T'] /2 ; }
							if ($adv) { 
							   if ($this->table_rotate) {
								$this->y += ($adv);
							   }
							   else {
								$this->DivLn($adv,$this->blklvl,true); 
							   }
							}
						}

						$outerfilled = 0;
						$y0 = $this->y; 
						$y = $y0;
					}

				}
				$skippage = true;
			}

			$this->x = $x; 
			$this->y = $y;

			if ($this->kwt_saved && $level==1) {
				$this->printkwtbuffer();
				$x0 = $x = $this->x; 
				$y0 = $y = $this->y;
				$this->kwt_moved = false;
				$this->kwt_saved = false;
			}


			// Set the Page & Column where table starts
			if ($i==0 && $j==0 && $level==1) {
				if (($this->mirrorMargins) && (($this->page)%2==0)) {				// EVEN
					$tablestartpage = 'EVEN'; 
				}
				else if (($this->mirrorMargins) && (($this->page)%2==1)) {				// ODD
					$tablestartpage = 'ODD'; 
				}
				else { $tablestartpage = ''; }
			}


			//ALIGN
			$align = $cell['a'];




			//TABLE BACKGROUND FILL BGCOLOR - for cellSpacing
			if ($table['borders_separate']) { 
			   $fill = isset($table['bgcolor'][-1]) ? $table['bgcolor'][-1] : 0;
			   if ($fill) {
  				$color = $this->ConvertColor($fill);
  				if ($color) $this->SetFillColor($color['R'],$color['G'],$color['B']);
				$xadj = ($table['border_spacing_H']/2);
				$yadj = ($table['border_spacing_V']/2);
				$wadj = $table['border_spacing_H'];
				$hadj = $table['border_spacing_V'];
 			   	if ($i == 0) {		// Top
					$yadj += $table['padding']['T'];
					$hadj += $table['padding']['T'];
			   	}
			   	if ($j == 0) {		// Left
					$xadj += $table['padding']['L'];
					$wadj += $table['padding']['L'];
			   	}
			   	if ($i == ($numrows-1) || (isset($cell['rowspan']) && ($i+$cell['rowspan']) == $numrows)  || (!isset($cell['rowspan']) && ($i+1) == $numrows)) {	// Bottom
					$hadj += $table['padding']['B'];
			   	}
			   	if ($j == ($numcols-1) || (isset($cell['colspan']) && ($j+$cell['colspan']) == $numcols)  || (!isset($cell['colspan']) && ($j+1) == $numcols)) {	// Right
					$wadj += $table['padding']['R'];
			   	}
				$this->Rect($x - $xadj, $y - $yadj, $w + $wadj, $h + $hadj, 'F');
			   }
			}

			// TABLE BORDER - if separate
 			if ($table['borders_separate'] && $table['border']) { 
			   $halfspaceL = $table['padding']['L'] + ($table['border_spacing_H']/2);
			   $halfspaceR = $table['padding']['R'] + ($table['border_spacing_H']/2);
			   $halfspaceT = $table['padding']['T'] + ($table['border_spacing_V']/2);
			   $halfspaceB = $table['padding']['B'] + ($table['border_spacing_V']/2);
			   $tbx = $x;
			   $tby = $y;
			   $tbw = $w;
			   $tbh = $h;
			   $tab_bord = 0;
			   
			   $corner = '';
 			   if ($i == 0) {		// Top
				$tby -= $halfspaceT + ($table['border_details']['T']['w']/2);
				$tbh += $halfspaceT + ($table['border_details']['T']['w']/2);
				$this->setBorder($tab_bord , _BORDER_TOP); 
				$corner .= 'T';
			   }
			   if ($i == ($numrows-1) || (isset($cell['rowspan']) && ($i+$cell['rowspan']) == $numrows)  || (!isset($cell['rowspan']) && ($i+1) == $numrows) ) {	// Bottom
				$tbh += $halfspaceB + ($table['border_details']['B']['w']/2);
				$this->setBorder($tab_bord , _BORDER_BOTTOM); 
				$corner .= 'B';
			   }
			   if ($j == 0) {		// Left
				$tbx -= $halfspaceL + ($table['border_details']['L']['w']/2);
				$tbw += $halfspaceL + ($table['border_details']['L']['w']/2);
				$this->setBorder($tab_bord , _BORDER_LEFT); 
				$corner .= 'L';
			   }
			   if ($j == ($numcols-1) || (isset($cell['colspan']) && ($j+$cell['colspan']) == $numcols)  || (!isset($cell['colspan']) && ($j+1) == $numcols)) {	// Right
				$tbw += $halfspaceR + ($table['border_details']['R']['w']/2);
				$this->setBorder($tab_bord , _BORDER_RIGHT); 
				$corner .= 'R';
			   }
			   $this->_tableRect($tbx, $tby, $tbw, $tbh, $tab_bord , $table['border_details'], false, $table['borders_separate'], 'table', $corner, $table['border_spacing_V'], $table['border_spacing_H'] );
			}

			if ($table['empty_cells']!='hide' || !empty($cell['textbuffer']) || (isset($cell['nestedcontent']) && $cell['nestedcontent']) || !$table['borders_separate']  ) { $paintcell = true; }
			else { $paintcell = false; } 

			//Set Borders
			$bord = 0; 
			$bord_det = array();

			if (!$this->simpleTables){
			 	if ($this->packTableData) {
	  			   if ($cell['borderbin']) {
					$c = $this->_unpackCellBorder($cell['borderbin']);
					$bord = $c['border'];
					$bord_det = $c['border_details'];
				   }
				}
				else if ($cell['border']) {
					$bord = $cell['border'];
					$bord_det = $cell['border_details'];
				}
			}
			else if ($this->simpleTables){
	  			if ($table['simple']['border']) {
					$bord = $table['simple']['border'];
					$bord_det = $table['simple']['border_details'];
				}
			}

			//CELL FILL BGCOLOR
			$fill = isset($cell['bgcolor']) ? $cell['bgcolor'] : 0;

			if ($fill && $paintcell) {
  				$color = $this->ConvertColor($fill);
  				if ($color) $this->SetFillColor($color['R'],$color['G'],$color['B']);
 				if ($table['borders_separate']) { 
 					$this->Rect($x+ ($table['border_spacing_H']/2), $y+ ($table['border_spacing_V']/2), $w- $table['border_spacing_H'], $h- $table['border_spacing_V'], 'F');
				}
 				else { 
	 				$this->Rect($x, $y, $w, $h, 'F');
				}
			}



			 if (isset($cell['colspan']) && $cell['colspan']>1) { $ccolsp = $cell['colspan']; }
			 else { $ccolsp = 1; }
			 if (isset($cell['rowspan']) && $cell['rowspan']>1) { $crowsp = $cell['rowspan']; }
			 else { $crowsp = 1; }


			// but still need to do this for repeated headers...
			if (!$table['borders_separate'] && $this->tabletheadjustfinished && !$this->simpleTables){
			  if (isset($table['topntail']) && $table['topntail']) {
					$bord_det['T'] = $this->border_details($table['topntail']);
					$bord_det['T']['w'] /= $this->shrin_k;
					$this->setBorder($bord, _BORDER_TOP); 
			  }
			  if (isset($table['thead-underline']) && $table['thead-underline']) {
					$bord_det['T'] = $this->border_details($table['thead-underline']);
					$bord_det['T']['w'] /= $this->shrin_k;
					$this->setBorder($bord, _BORDER_TOP); 
			  }
			}



			//Get info of first row ==>> table header
			//Use > 1 row if THEAD
			if ($this->usetableheader && ($i == 0  || (isset($table['is_thead'][$i]) && $table['is_thead'][$i])) && $level==1) {
				$tableheader[$i][$j]['x'] = $x;
				$tableheader[$i][$j]['y'] = $y;
				$tableheader[$i][$j]['h'] = $h;
				$tableheader[$i][$j]['w'] = $w;
				$tableheader[$i][$j]['text'] = $cell['text'];
				if (isset($cell['textbuffer'])) { $tableheader[$i][$j]['textbuffer'] = $cell['textbuffer']; }
				else { $tableheader[$i][$j]['textbuffer'] = ''; }
				$tableheader[$i][$j]['a'] = $cell['a'];
				$tableheader[$i][$j]['R'] = $cell['R'];

				$tableheader[$i][$j]['va'] = $cell['va'];
				$tableheader[$i][$j]['mih'] = $cell['mih'];
				$tableheader[$i][$j]['rowspan'] = $cell['rowspan'];
				$tableheader[$i][$j]['colspan'] = $cell['colspan'];
				$tableheader[$i][$j]['bgcolor'] = $fill;

				if (!$this->simpleTables){
					$tableheader[$i][$j]['border'] = $bord;
					$tableheader[$i][$j]['border_details'] = $bord_det;
				}
				else if ($this->simpleTables){
					$tableheader[$i][$j]['border'] = $table['simple']['border'];
					$tableheader[$i][$j]['border_details'] = $table['simple']['border_details'];
				}
				$tableheader[$i][$j]['padding'] = $cell['padding'];
			}

			// CELL BORDER
			if ($bord || $bord_det) { 
 				if ($table['borders_separate'] && $paintcell) {
 					$this->_tableRect($x + ($table['border_spacing_H']/2)+($bord_det['L']['w'] /2), $y+ ($table['border_spacing_V']/2)+($bord_det['T']['w'] /2), $w-$table['border_spacing_H']-($bord_det['L']['w'] /2)-($bord_det['R']['w'] /2), $h- $table['border_spacing_V']-($bord_det['T']['w'] /2)-($bord_det['B']['w']/2), $bord, $bord_det, false, $table['borders_separate']);
				}
 				else if (!$table['borders_separate']) { 
					$this->_tableRect($x, $y, $w, $h, $bord, $bord_det, true, $table['borders_separate']); 	// true causes buffer
				}

			}

			//VERTICAL ALIGN
			if ($cell['R'] && INTVAL($cell['R']) > 0 && INTVAL($cell['R']) < 90 && isset($cell['va']) && $cell['va']!='B') { $cell['va']='B';}
			if (!isset($cell['va']) || $cell['va']=='M') $this->y += ($h-$cell['mih'])/2;
			elseif (isset($cell['va']) && $cell['va']=='B') $this->y += $h-$cell['mih'];

			// NESTED CONTENT 

			// TEXT (and nested tables)
			$this->divalign=$align;

			$this->divwidth=$w;
			if (!empty($cell['textbuffer'])) {
				$opy = $this->y;
				// mPDF ITERATION
				if ($this->iterationCounter) {
				   foreach($cell['text'] AS $k=>$t) {
					if (preg_match('/{iteration ([a-zA-Z0-9_]+)}/',$t, $m)) {
						$vname = '__'.$m[1].'_';
						if (!isset($this->$vname)) { $this->$vname = 1; }
						else { $this->$vname++; }
						$cell['text'][$k] = preg_replace('/{iteration '.$m[1].'}/', $this->$vname, $cell['text'][$k]);
						$cell['textbuffer'][$k][0] = preg_replace('/{iteration '.$m[1].'}/', $this->$vname, $cell['textbuffer'][$k][0]);
					}
				   }
				}


				if ($cell['R']) {
					$cellPtSize = $cell['textbuffer'][0][11] / $this->shrin_k;
					if (!$cellPtSize) { $cellPtSize = $this->default_font_size; }
					$cellFontHeight = ($cellPtSize/$this->k);
					$opx = $this->x;
					$angle = INTVAL($cell['R']);
					// Only allow 45 to 89 degrees (when bottom-aligned) or exactly 90 or -90
					if ($angle > 90) { $angle = 90; }
					else if ($angle > 0 && $angle <45) { $angle = 45; }
					else if ($angle < 0) { $angle = -90; }
					$offset = ((sin(deg2rad($angle))) * 0.37 * $cellFontHeight);
					if (isset($cell['a']) && $cell['a']=='R') { 
						$this->x += ($w) + ($offset) - ($cellFontHeight/3) - ($cell['padding']['R'] + ($table['border_spacing_H']/2)); 
					}
					else if (!isset($cell['a']) || $cell['a']=='C') { 
						$this->x += ($w/2) + ($offset); 
					}
					else { 
						$this->x += ($offset) + ($cellFontHeight/3)+($cell['padding']['L'] +($table['border_spacing_H']/2)); 
					}
					$str = trim(implode(' ',$cell['text']));
					if (!isset($cell['va']) || $cell['va']=='M') { 
						$this->y -= ($h-$cell['mih'])/2; //Undo what was added earlier VERTICAL ALIGN
						if ($angle > 0) { $this->y += (($h-$cell['mih'])/2) + $cell['padding']['T'] + ($cell['mih']-($cell['padding']['T'] + $cell['padding']['B'])); }
						else if ($angle < 0) { $this->y += (($h-$cell['mih'])/2)+ ($cell['padding']['T'] + ($table['border_spacing_V']/2)); }
					}
					elseif (isset($cell['va']) && $cell['va']=='B') { 
						$this->y -= $h-$cell['mih']; //Undo what was added earlier VERTICAL ALIGN
						if ($angle > 0) { $this->y += $h-($cell['padding']['B'] + ($table['border_spacing_V']/2)); }
						else if ($angle < 0) { $this->y += $h-$cell['mih'] + ($cell['padding']['T'] + ($table['border_spacing_V']/2)); }
					}
					elseif (isset($cell['va']) && $cell['va']=='T') { 
						if ($angle > 0) { $this->y += $cell['mih']-($cell['padding']['B'] + ($table['border_spacing_V']/2)); }
						else if ($angle < 0) { $this->y += ($cell['padding']['T'] + ($table['border_spacing_V']/2)); }
					}
					$this->Rotate($angle,$this->x,$this->y);
					$s_fs = $this->FontSizePt;
					$s_f = $this->FontFamily;
					$s_st = $this->FontStyle;
					$this->SetFont($cell['textbuffer'][0][4],$cell['textbuffer'][0][2],$cellPtSize,true,true);
					$this->Text($this->x,$this->y,$str);
					$this->Rotate(0);
					$this->SetFont($s_f,$s_st,$s_fs,true,true);
					$this->x = $opx;
				}
				else {

					if (!$this->simpleTables){
					   if ($table['borders_separate']) {
						$xadj = $bord_det['L']['w'] + $cell['padding']['L'] +($table['border_spacing_H']/2);
						$wadj = $bord_det['L']['w'] + $bord_det['R']['w'] + $cell['padding']['L'] +$cell['padding']['R'] + $table['border_spacing_H'];
						$yadj = $bord_det['T']['w'] + $cell['padding']['T'] + ($table['border_spacing_H']/2);
					   }
					   else {
						$xadj = $bord_det['L']['w']/2 + $cell['padding']['L'];
						$wadj = ($bord_det['L']['w'] + $bord_det['R']['w'])/2 + $cell['padding']['L'] + $cell['padding']['R'];
						$yadj = $bord_det['T']['w']/2 + $cell['padding']['T'];
					   }
					}
					else if ($this->simpleTables){
					   if ($table['borders_separate']) {	// NB twice border width
						$xadj = $table['simple']['border_details']['L']['w'] + $cell['padding']['L'] +($table['border_spacing_H']/2);
						$wadj = $table['simple']['border_details']['L']['w'] + $table['simple']['border_details']['R']['w'] + $cell['padding']['L'] +$cell['padding']['R'] + $table['border_spacing_H'];
						$yadj = $table['simple']['border_details']['T']['w'] + $cell['padding']['T'] + ($table['border_spacing_H']/2);
					   }
					   else {
						$xadj = $table['simple']['border_details']['L']['w']/2 + $cell['padding']['L'];
						$wadj = ($table['simple']['border_details']['L']['w'] + $table['simple']['border_details']['R']['w'])/2 + $cell['padding']['L'] + $cell['padding']['R'];
						$yadj = $table['simple']['border_details']['T']['w']/2 + $cell['padding']['T'];
					   }
					}

					$this->divwidth=$w-$wadj;
					if ($this->divwidth == 0) { $this->divwidth = 0.0001; }
					$this->x += $xadj;
					$this->y += $yadj;
					$this->printbuffer($cell['textbuffer'],'',true);
				}
				$this->y = $opy;
			}
			unset($cell );
			//Reset values
			$this->Reset();
		}//end of (if isset(cells)...)
	  }// end of columns

	  $newpagestarted = false;
	  $this->tabletheadjustfinished = false;




	  if ($i == $numrows-1) { $this->y = $y + $h; } //last row jump (update this->y position)
	  if ($this->table_rotate && $level==1) {
		$this->tbrot_h += $h;
	  }

	}// end of rows

	if ($this->progressBar) { $this->UpdateProgressBar(7,70,' '); }

	if (count($this->cellBorderBuffer)) { $this->printcellbuffer(); }

 
	if ($this->tableClipPath ) { $this->_out("Q"); }
	$this->tableClipPath = '';

	// Advance down page by half width of bottom border
 	if ($table['borders_separate']) { $this->y += $table['padding']['B'] + $table['border_details']['B']['w'] + $table['border_spacing_V']/2; }
	else { $this->y += $table['max_cell_border_width']['B']/2; }

	if ($table['borders_separate'] && $level==1) { $this->tbrot_h += $table['margin']['B'] + $table['padding']['B'] + $table['border_details']['B']['w'] + $table['border_spacing_V']/2; }
	else if ($level==1) { $this->tbrot_h += $table['margin']['B'] + $table['max_cell_border_width']['B']/2; }


	// TABLE BOTTOM MARGIN
	if ($table['margin']['B']) {
	  if (!$this->table_rotate && $level==1) {
		$this->DivLn($table['margin']['B'],$this->blklvl,true); 	// collapsible
	  }
	  else {
		$this->y += ($table['margin']['B']);
	  }
	}


}//END OF FUNCTION _tableWrite()


/////////////////////////END OF TABLE CODE//////////////////////////////////


function _putextgstates() {
	for ($i = 1; $i <= count($this->extgstates); $i++) {
            $this->_newobj();
            $this->extgstates[$i]['n'] = $this->n;
            $this->_out('<</Type /ExtGState');
            foreach ($this->extgstates[$i]['parms'] as $k=>$v)
                $this->_out('/'.$k.' '.$v);
            $this->_out('>>');
            $this->_out('endobj');
	}
}












function _putresources() {
	$this->_putextgstates();
	if ($this->progressBar) { $this->UpdateProgressBar(2,'40','Compiling Fonts'); }
	$this->_putfonts();
	if ($this->progressBar) { $this->UpdateProgressBar(2,'50','Compiling Images'); }
	$this->_putimages();
	$this->_putformobjects();	// *IMAGES-CORE*


	//Resource dictionary
	$this->offsets[2]=strlen($this->buffer);
	$this->_out('2 0 obj');
	$this->_out('<</ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
	$this->_out('/Font <<');
	foreach($this->fonts as $font) {
		if (!$font['used'] && $font['type']=='TTF') { continue; }
		if ($font['type']=='TTF' && ($font['sip'] || $font['smp'])) {	// mPDF 5.0.03 Added SMP
			foreach($font['n'] AS $k => $fid) {
				$this->_out('/F'.$font['subsetfontids'][$k].' '.$font['n'][$k].' 0 R');
			}
		}
		else { 
			$this->_out('/F'.$font['i'].' '.$font['n'].' 0 R');
		}
	}
	$this->_out('>>');
	if (count($this->extgstates)) {
		$this->_out('/ExtGState <<');
		foreach($this->extgstates as $k=>$extgstate)
			$this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
		$this->_out('>>');
	}


	if(count($this->images) || count($this->formobjects) || ($this->enableImports && count($this->tpls))) {
		$this->_out('/XObject <<');
		foreach($this->images as $image)
			$this->_out('/I'.$image['i'].' '.$image['n'].' 0 R');
            foreach($this->formobjects as $formobject)
                $this->_out('/FO'.$formobject['i'].' '.$formobject['n'].' 0 R');
		$this->_out('>>');
	}


	$this->_out('>>');
	$this->_out('endobj');	// end resource dictionary

	$this->_putbookmarks(); 	// *BOOKMARKS*

}


	function _puttrailer()
	{
		$this->_out('/Size '.($this->n+1));
		$this->_out('/Root '.$this->n.' 0 R');
		$this->_out('/Info '.$this->InfoRoot.' 0 R');
			$uniqid = md5(time() .  $this->buffer);
			$this->_out('/ID [<'.$uniqid.'> <'.$uniqid.'>]');
	}


//=========================================
// FROM class PDF_Bookmark

function Bookmark($txt,$level=0,$y=0)
{
	$txt = $this->purify_utf8_text($txt);
	if ($this->text_input_as_HTML) {
		$txt = $this->all_entities_to_utf8($txt);
	}
	if($y==-1) {
		if (!$this->ColActive){ $y=$this->y; }
		else { $y = $this->y0; }	// If columns are on - mark top of columns
	}
	// else y is used as set, or =0 i.e. top of page
	// DIRECTIONALITY RTL

	if ($this->keep_block_together) {
		$this->ktBMoutlines[]=array('t'=>$txt,'l'=>$level,'y'=>$y,'p'=>$this->page);
	}
	else {
		$this->BMoutlines[]=array('t'=>$txt,'l'=>$level,'y'=>$y,'p'=>$this->page);
	}
}


function _putbookmarks()
{
	$nb=count($this->BMoutlines);
	if($nb==0)
		return;
	$lru=array();
	$level=0;
	foreach($this->BMoutlines as $i=>$o)
	{
		if($o['l']>0)
		{
			$parent=$lru[$o['l']-1];
			//Set parent and last pointers
			$this->BMoutlines[$i]['parent']=$parent;
			$this->BMoutlines[$parent]['last']=$i;
			if($o['l']>$level)
			{
				//Level increasing: set first pointer
				$this->BMoutlines[$parent]['first']=$i;
			}
		}
		else
			$this->BMoutlines[$i]['parent']=$nb;
		if($o['l']<=$level and $i>0)
		{
			//Set prev and next pointers
			$prev=$lru[$o['l']];
			$this->BMoutlines[$prev]['next']=$i;
			$this->BMoutlines[$i]['prev']=$prev;
		}
		$lru[$o['l']]=$i;
		$level=$o['l'];
	}
	//Outline items
	$n=$this->n+1;
	foreach($this->BMoutlines as $i=>$o)
	{
		$this->_newobj();
		$this->_out('<</Title '.$this->_UTF16BEtextstring($o['t']));
		$this->_out('/Parent '.($n+$o['parent']).' 0 R');
		if(isset($o['prev']))
			$this->_out('/Prev '.($n+$o['prev']).' 0 R');
		if(isset($o['next']))
			$this->_out('/Next '.($n+$o['next']).' 0 R');
		if(isset($o['first']))
			$this->_out('/First '.($n+$o['first']).' 0 R');
		if(isset($o['last']))
			$this->_out('/Last '.($n+$o['last']).' 0 R');


		if (isset($this->pageDim[$o['p']]['h'])) { $h=$this->pageDim[$o['p']]['h']; }
		else { $h = 0; }

		$this->_out(sprintf('/Dest [%d 0 R /XYZ 0 %.3f null]',1+2*($o['p']),($h-$o['y'])*$this->k));

		$this->_out('/Count 0>>');
		$this->_out('endobj');
	}
	//Outline root
	$this->_newobj();
	$this->OutlineRoot=$this->n;
	$this->_out('<</Type /BMoutlines /First '.$n.' 0 R');
	$this->_out('/Last '.($n+$lru[0]).' 0 R>>');
	$this->_out('endobj');
}
	// *BOOKMARKS*



//======================================================


// DEPRACATED but included for backwards compatability
function startPageNums() {
}

//======================================================



//======================================================


function AcceptPageBreak() {
        	$this->ChangeColumn=0;
		return $this->autoPageBreak;
	return $this->autoPageBreak;
}


//----------- COLUMNS ---------------------


//==================================================================


//==================================================================

function printfloatbuffer() {
	if (count($this->floatbuffer)) {
		$this->objectbuffer = $this->floatbuffer;
		$this->printobjectbuffer(false);
		$this->objectbuffer = array();
		$this->floatbuffer = array();
		$this->floatmargins = array();
	}
}
//==================================================================

function printdivbuffer() {
	$k = $this->k;
	$p1 = $this->blk[$this->blklvl]['startpage'];
	$p2 = $this->page;
	$bottom[$p1] = $this->ktBlock[$p1]['bottom_margin'];
	$bottom[$p2] = $this->y;	// $this->ktBlock[$p2]['bottom_margin'];
	$top[$p1] = $this->kt_y00;	// mPDF 5.0

	$top2 = $this->h;
	foreach($this->divbuffer AS $key=>$s) { 
		if ($s['page'] == $p2) {
			$top2 = MIN($s['y'], $top2);
		}
	}
	$top[$p2] = $top2;
	$height[$p1] = ($bottom[$p1] - $top[$p1]);
	$height[$p2] = ($bottom[$p2] - $top[$p2]);
	$xadj[$p1] = $this->MarginCorrection;
	$yadj[$p1] = -($top[$p1] - $top[$p2]);
	$xadj[$p2] = 0;
	$yadj[$p2] = $height[$p1];

	if ($this->ColActive || !$this->keep_block_together || $this->blk[$this->blklvl]['startpage'] == $this->page || ($this->page - $this->blk[$this->blklvl]['startpage']) > 1 || ($height[$p1]+$height[$p2]) > $this->h) { 
		foreach($this->divbuffer AS $s) { $this->pages[$s['page']] .= $s['s']."\n"; }
		foreach($this->ktLinks AS $p => $l) {
		   foreach($l AS $v) {
			$this->PageLinks[$p][] = $v;
		   }
		}

	      // Adjust Bookmarks
	      foreach($this->ktBMoutlines AS $v) {
			$this->BMoutlines[]=array('t'=>$v['t'],'l'=>$v['l'],'y'=>$v['y'],'p'=>$v['p']);
	      }


		$this->divbuffer = array();
		$this->ktLinks = array();
		$this->ktAnnots = array();
		$this->ktBlock = array();
		$this->ktReference = array();
		$this->ktBMoutlines = array();
		$this->_kttoc = array();
		$this->keep_block_together = 0;
		return; 
	}
	else {
	   // mPDF 5.0 Move stuff before ___PAGE___START marker and put it after ___HEADER_MARKER
	   $np = '';
	   $pre = '';
	   $ispre = true;
	   foreach($this->divbuffer AS $key=>$s) { 
		// callback function
		$t = $s['s'];
		$p = $s['page'];
		if (preg_match('/(___PAGE___START'.date('jY').')/', $t)) { $ispre = false; }
		else if (preg_match('/(___HEADER___MARKER'.date('jY').')/', $t)) { 
			$np .= $t."\n".$pre;
			continue; 
		}
		else {
		  $t = preg_replace('/BT (\d+\.\d\d+) (\d+\.\d\d+) Td/e',"\$this->blockAdjust('Td',$k,$xadj[$p],$yadj[$p],'\\1','\\2')",$t);
		  $t = preg_replace('/(\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) ([\-]{0,1}\d+\.\d\d+) re/e',"\$this->blockAdjust('re',$k,$xadj[$p],$yadj[$p],'\\1','\\2','\\3','\\4')",$t);
		  $t = preg_replace('/(\d+\.\d\d+) (\d+\.\d\d+) l/e',"\$this->blockAdjust('l',$k,$xadj[$p],$yadj[$p],'\\1','\\2')",$t);
		  $t = preg_replace('/q (\d+\.\d\d+) 0 0 (\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) cm \/(I|FO)/e',"\$this->blockAdjust('img',$k,$xadj[$p],$yadj[$p],'\\1','\\2','\\3','\\4','\\5')",$t); 
		  $t = preg_replace('/(\d+\.\d\d+) (\d+\.\d\d+) m/e',"\$this->blockAdjust('draw',$k,$xadj[$p],$yadj[$p],'\\1','\\2')",$t);
		  $t = preg_replace('/(\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) c/e',"\$this->blockAdjust('bezier',$k,$xadj[$p],$yadj[$p],'\\1','\\2','\\3','\\4','\\5','\\6')",$t);
		}
		// mPDF 5.0
	      if ($ispre) $pre .= $t."\n";
		else $np .= $t."\n";
	   }
	   // mPDF 5.0
	   if ($ispre && $pre) $np = $pre ."\n". $np;	// Failsafe
	   $this->pages[$this->page] .= $np;

	   // Adjust hyperLinks
	   foreach($this->ktLinks AS $p => $l) {
	    foreach($l AS $v) {
		$v[0] += ($xadj[$p]*$k);
		$v[1] -= ($yadj[$p]*$k);
		$this->PageLinks[$p2][] = $v;
	    }
	   }

	   // Adjust Bookmarks
	   foreach($this->ktBMoutlines AS $v) {
		if ($v['y'] != 0) { $v['y'] += ($yadj[$v['p']]); }
		$this->BMoutlines[]=array('t'=>$v['t'],'l'=>$v['l'],'y'=>$v['y'],'p'=>$p2);
	   }



	   $this->y = $top[$p2] + $height[$p1] + $height[$p2];
	   $this->x = $this->lMargin;

	   $this->divbuffer = array();
	   $this->ktLinks = array();
	   $this->ktAnnots = array();
	   $this->ktBlock = array();
	   $this->ktReference = array();
	   $this->ktBMoutlines = array();
	   $this->_kttoc = array();
	   $this->keep_block_together = 0;
	}
}


//==================================================================
// Added ELLIPSES and CIRCLES
function Circle($x,$y,$r,$style='S') {
	$this->Ellipse($x,$y,$r,$r,$style);
}

function Ellipse($x,$y,$rx,$ry,$style='S') {
	if($style=='F') { $op='f'; }
	elseif($style=='FD' or $style=='DF') { $op='B'; }
	else { $op='S'; }
	$lx=4/3*(M_SQRT2-1)*$rx;
	$ly=4/3*(M_SQRT2-1)*$ry;
	$k=$this->k;
	$h=$this->h;
	$this->_out(sprintf('%.3f %.3f m %.3f %.3f %.3f %.3f %.3f %.3f c', ($x+$rx)*$k,($h-$y)*$k, ($x+$rx)*$k,($h-($y-$ly))*$k, ($x+$lx)*$k,($h-($y-$ry))*$k, $x*$k,($h-($y-$ry))*$k));
	$this->_out(sprintf('%.3f %.3f %.3f %.3f %.3f %.3f c', ($x-$lx)*$k,($h-($y-$ry))*$k, 	($x-$rx)*$k,($h-($y-$ly))*$k, 	($x-$rx)*$k,($h-$y)*$k)); 
	$this->_out(sprintf('%.3f %.3f %.3f %.3f %.3f %.3f c', ($x-$rx)*$k,($h-($y+$ly))*$k, ($x-$lx)*$k,($h-($y+$ry))*$k, $x*$k,($h-($y+$ry))*$k)); 
	$this->_out(sprintf('%.3f %.3f %.3f %.3f %.3f %.3f c %s', ($x+$lx)*$k,($h-($y+$ry))*$k, ($x+$rx)*$k,($h-($y+$ly))*$k, ($x+$rx)*$k,($h-$y)*$k, $op));
}






// ====================================================
// ====================================================

// 
// ****************************
// ****************************


function SetSubstitutions() {
	$subsarray = array();
	@include(_MPDF_PATH.'includes/subs_win-1252.php');
	$this->substitute = array();
	foreach($subsarray AS $key => $val) {
		$this->substitute[code2utf($key)] = $val;
	}
}


function SubstituteChars($html) {
	// only substitute characters between tags
	if (count($this->substitute)) {
		$a=preg_split('/(<.*?>)/ms',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		$html = '';
		foreach($a as $i => $e) {
			if($i%2==0) {
			   $e = strtr($e, $this->substitute);
			}
			$html .= $e;
		}
	}
	return $html;
}


// mPDF 5.0
function SubstituteCharsSIP(&$writehtml_a, &$writehtml_i, &$writehtml_e) {
	if (preg_match("/^(.*?)([\x{20000}-\x{2FFFF}]+)(.*)/u", $writehtml_e, $m)) { 
	   if (isset($this->CurrentFont['sipext']) && $this->CurrentFont['sipext']) {
		$font = $this->CurrentFont['sipext']; 
		if (!in_array($font, $this->available_unifonts)) { return 0; }
		$writehtml_a[$writehtml_i] = $writehtml_e = $m[1];
		array_splice($writehtml_a, $writehtml_i+1, 0, array('span style="font-family: '.$font.'"', $m[2], '/span', $m[3]));
		$this->subPos = $writehtml_i;
		return 4;
	   }
	}
	return 0; 
}


function SubstituteCharsMB(&$writehtml_a, &$writehtml_i, &$writehtml_e) {
	$cw = &$this->CurrentFont['cw'];
	$unicode = $this->UTF8StringToArray($writehtml_e, false);
	$start = -1;
	$end = 0;
	$flag = 0;
	$ftype = '';
	$u = array();
	foreach($unicode AS $c => $char) {
		// mPDF 5.0
		if (($flag == 0 || $flag==2) && (!$this->_charDefined($cw,$char) || ($flag==2 && $char==32)) && $this->checkSIP && $char > 131071) { 	// Unicode Plane 2 (SIP)
			if (in_array($this->FontFamily ,$this->available_CJK_fonts)) { return 0; }
			if ($flag==0) { $start=$c; }
			$flag=2; 
			$u[] = $char;
		}
		// mPDF5.0
		//else if (($flag == 0 || $flag==1) && $char != 173 && !$this->_charDefined($cw,$char) && ($char<1423 ||  ($char>3583 && $char < 11263))) { 
		else if (($flag == 0 || $flag==1) && $char != 173 && (!$this->_charDefined($cw,$char) || ($flag==1 && $char==32)) && ($char<1536 ||  ($char>1791 && $char < 2304) || $char>3455)) { 
			if ($flag==0) { $start=$c; }
			$flag=1; 
			$u[] = $char;
		}
		else if ($flag>0) { $end=$c-1; break; }
	}
	if ($flag>0 && !$end) { $end=count($unicode)-1; }
	if ($start==-1) { return 0; }

	if ($flag == 2) { 	// SIP
		// Check if current CJK font has a ext-B related font
	   if (isset($this->CurrentFont['sipext']) && $this->CurrentFont['sipext']) {
		$font = $this->CurrentFont['sipext']; 
		unset($cw);
		$cw = '';
		if (isset($this->fonts[$font])) { $cw = &$this->fonts[$font]['cw']; }
		else if (file_exists(_MPDF_TTFONTDATAPATH.$font.'.cw.dat')) { $cw = @file_get_contents(_MPDF_TTFONTDATAPATH.$font.'.cw.dat'); }
		else {
			$prevFontFamily = $this->FontFamily;
			$prevFontStyle = $this->currentfontstyle;
			$prevFontSizePt = $this->FontSizePt;
			$this->SetFont($font, '', '', false);
			$cw = @file_get_contents(_MPDF_TTFONTDATAPATH.$font.'.cw.dat');
			$this->SetFont($prevFontFamily, $prevFontStyle, $prevFontSizePt, false);
		}
		if (!$cw) { return 0; }
		$l = 0;
		foreach($u AS $char) {
			if ($this->_charDefined($cw,$char) || $char > 131071) {
				$l++;
			}
			else { break; }
		}
		if ($l > 0) {
			$patt = mb_substr($writehtml_e, $start, $l);
			if (preg_match("/(.*?)(".preg_quote($patt,'/').")(.*)/u", $writehtml_e, $m)) {
				$writehtml_e = $m[1];
				array_splice($writehtml_a, $writehtml_i+1, 0, array('span style="font-family: '.$font.'"', $m[2], '/span', $m[3]));
				$this->subPos = $writehtml_i+3;
				return 4;
			}
		}
	   }
		// Check Backup SIP font (defined in config_fonts.php)
	   if (isset($this->backupSIPFont) && $this->backupSIPFont) {
		if ($this->currentfontfamily != $this->backupSIPFont) { $font = $this->backupSIPFont; }
		else { unset($cw); return 0; }
		unset($cw);
		$cw = '';
		if (isset($this->fonts[$font])) { $cw = &$this->fonts[$font]['cw']; }
		else if (file_exists(_MPDF_TTFONTDATAPATH.$font.'.cw.dat')) { $cw = @file_get_contents(_MPDF_TTFONTDATAPATH.$font.'.cw.dat'); }
		else {
			$prevFontFamily = $this->FontFamily;
			$prevFontStyle = $this->currentfontstyle;
			$prevFontSizePt = $this->FontSizePt;
			$this->SetFont($this->backupSIPFont, '', '', false);
			$cw = @file_get_contents(_MPDF_TTFONTDATAPATH.$font.'.cw.dat');
			$this->SetFont($prevFontFamily, $prevFontStyle, $prevFontSizePt, false);
		}
		if (!$cw) { return 0; }
		$l = 0;
		foreach($u AS $char) {
			if ($this->_charDefined($cw,$char) || $char > 131071) {
				$l++;
			}
			else { break; }
		}
		if ($l > 0) {
			$patt = mb_substr($writehtml_e, $start, $l);
			if (preg_match("/(.*?)(".preg_quote($patt,'/').")(.*)/u", $writehtml_e, $m)) {
				$writehtml_e = $m[1];
				array_splice($writehtml_a, $writehtml_i+1, 0, array('span style="font-family: '.$font.'"', $m[2], '/span', $m[3]));
				$this->subPos = $writehtml_i+3;
				return 4;
			}
		}
	   }
	   return 0; 
	}


	// FIRST TRY CORE FONTS
	if (!$this->PDFA) { 
	  $repl = array();	// mPDF 5.0
	  if (!$this->subArrMB) { 
		include(_MPDF_PATH.'includes/subs_core.php'); 
		$this->subArrMB['a'] = $aarr;
		$this->subArrMB['s'] = $sarr;
		$this->subArrMB['z'] = $zarr;
	  }
	  if (isset($this->subArrMB['a'][$u[0]])) { 
		$font = 'tta'; $ftype = 'C'; 
		foreach($u AS $char) {
			if ($this->subArrMB['a'][$char]) { $repl[] = $this->subArrMB['a'][$char]; }
			else { break; }
		}
	  }
	  else if (isset($this->subArrMB['z'][$u[0]])) { 
		$font = 'ttz'; $ftype = 'C'; 
		foreach($u AS $char) {
			if ($this->subArrMB['z'][$char]) { $repl[] = $this->subArrMB['z'][$char]; }
			else { break; }
		}
	  }
	  else if (isset($this->subArrMB['s'][$u[0]])) { 
		$font = 'tts'; $ftype = 'C'; 
		foreach($u AS $char) {
			if ($this->subArrMB['s'][$char]) { $repl[] = $this->subArrMB['s'][$char]; }
			else { break; }
		}
	  }
	  if ($ftype=='C') {
		$patt = mb_substr($writehtml_e, $start, count($repl));
		if (preg_match("/(.*?)(".preg_quote($patt,'/').")(.*)/u", $writehtml_e, $m)) {
			$writehtml_e = $m[1];
			array_splice($writehtml_a, $writehtml_i+1, 0, array($font, implode('|', $repl), '/'.$font, $m[3]));	// e.g. <tts>
			$this->subPos = $writehtml_i+3;
			return 4;
		}
		return 0;
	  }
	}

	// FIND IN DEFAULT FONT - removed mPDF 5.0

	// LASTLY TRY IN BACKUP SUBS FONT
	if (!is_array($this->backupSubsFont)) { $this->backupSubsFont = array("$this->backupSubsFont"); }
	foreach($this->backupSubsFont AS $bsfctr=>$bsf) {	// mPDF 5.0Beta.02
		if ($this->currentfontfamily != $bsf) { $font = $bsf; }	// mPDF 5.0 not font['name']
		else { continue; }
		unset($cw);
		$cw = '';
		if (isset($this->fonts[$font])) { $cw = &$this->fonts[$font]['cw']; }
		else if (file_exists(_MPDF_TTFONTDATAPATH.$font.'.cw.dat')) { $cw = @file_get_contents(_MPDF_TTFONTDATAPATH.$font.'.cw.dat'); }
		else {
			$prevFontFamily = $this->FontFamily;
			$prevFontStyle = $this->currentfontstyle;
			$prevFontSizePt = $this->FontSizePt;
			$this->SetFont($bsf, '', '', false);
			$cw = @file_get_contents(_MPDF_TTFONTDATAPATH.$font.'.cw.dat');
			$this->SetFont($prevFontFamily, $prevFontStyle, $prevFontSizePt, false);
		}
		if (!$cw) { continue; }
		$l = 0;
		foreach($u AS $char) {
			// mPDF 5.0
			//if ($char == 173 || $this->_charDefined($cw,$char) || ($char>1422 && $char<3584) || $char > 11262) { 	// Arabic and Indic & CJK
			if ($char == 173 || $this->_charDefined($cw,$char) || ($char>1536 && $char<1791) || ($char>2304 && $char<3455 )) { 	// Arabic and Indic 
				$l++;
			}
			else { 	// mPDF 5.0
				if ($l==0 && $bsfctr == (count($this->backupSubsFont)-1)) {	// Not found even in last backup font
					$cont = mb_substr($writehtml_e, $start+1);
					$writehtml_e = mb_substr($writehtml_e, 0, $start+1);
					array_splice($writehtml_a, $writehtml_i+1, 0, array('', $cont));
					$this->subPos = $writehtml_i+1;
					return 2;
				}
				else { break; }
			}
		}
		if ($l > 0) {
			$patt = mb_substr($writehtml_e, $start, $l);
			if (preg_match("/(.*?)(".preg_quote($patt,'/').")(.*)/u", $writehtml_e, $m)) {
				$writehtml_e = $m[1];
				array_splice($writehtml_a, $writehtml_i+1, 0, array('span style="font-family: '.$font.'"', $m[2], '/span', $m[3]));
				$this->subPos = $writehtml_i+3;
				return 4;
			}
		}
	}

	unset($cw); 
	return 0;
}


function setHiEntitySubstitutions() {
	$entarr = array (
  'nbsp' => '160',  'iexcl' => '161',  'cent' => '162',  'pound' => '163',  'curren' => '164',  'yen' => '165',  'brvbar' => '166',  'sect' => '167',
  'uml' => '168',  'copy' => '169',  'ordf' => '170',  'laquo' => '171',  'not' => '172',  'shy' => '173',  'reg' => '174',  'macr' => '175',
  'deg' => '176',  'plusmn' => '177',  'sup2' => '178',  'sup3' => '179',  'acute' => '180',  'micro' => '181',  'para' => '182',  'middot' => '183',
  'cedil' => '184',  'sup1' => '185',  'ordm' => '186',  'raquo' => '187',  'frac14' => '188',  'frac12' => '189',  'frac34' => '190',
  'iquest' => '191',  'Agrave' => '192',  'Aacute' => '193',  'Acirc' => '194',  'Atilde' => '195',  'Auml' => '196',  'Aring' => '197',
  'AElig' => '198',  'Ccedil' => '199',  'Egrave' => '200',  'Eacute' => '201',  'Ecirc' => '202',  'Euml' => '203',  'Igrave' => '204',
  'Iacute' => '205',  'Icirc' => '206',  'Iuml' => '207',  'ETH' => '208',  'Ntilde' => '209',  'Ograve' => '210',  'Oacute' => '211',
  'Ocirc' => '212',  'Otilde' => '213',  'Ouml' => '214',  'times' => '215',  'Oslash' => '216',  'Ugrave' => '217',  'Uacute' => '218',
  'Ucirc' => '219',  'Uuml' => '220',  'Yacute' => '221',  'THORN' => '222',  'szlig' => '223',  'agrave' => '224',  'aacute' => '225',
  'acirc' => '226',  'atilde' => '227',  'auml' => '228',  'aring' => '229',  'aelig' => '230',  'ccedil' => '231',  'egrave' => '232',
  'eacute' => '233',  'ecirc' => '234',  'euml' => '235',  'igrave' => '236',  'iacute' => '237',  'icirc' => '238',  'iuml' => '239',
  'eth' => '240',  'ntilde' => '241',  'ograve' => '242',  'oacute' => '243',  'ocirc' => '244',  'otilde' => '245',  'ouml' => '246',
  'divide' => '247',  'oslash' => '248',  'ugrave' => '249',  'uacute' => '250',  'ucirc' => '251',  'uuml' => '252',  'yacute' => '253',
  'thorn' => '254',  'yuml' => '255',  'OElig' => '338',  'oelig' => '339',  'Scaron' => '352',  'scaron' => '353',  'Yuml' => '376',
  'fnof' => '402',  'circ' => '710',  'tilde' => '732',  'Alpha' => '913',  'Beta' => '914',  'Gamma' => '915',  'Delta' => '916',
  'Epsilon' => '917',  'Zeta' => '918',  'Eta' => '919',  'Theta' => '920',  'Iota' => '921',  'Kappa' => '922',  'Lambda' => '923',
  'Mu' => '924',  'Nu' => '925',  'Xi' => '926',  'Omicron' => '927',  'Pi' => '928',  'Rho' => '929',  'Sigma' => '931',  'Tau' => '932',
  'Upsilon' => '933',  'Phi' => '934',  'Chi' => '935',  'Psi' => '936',  'Omega' => '937',  'alpha' => '945',  'beta' => '946',  'gamma' => '947',
  'delta' => '948',  'epsilon' => '949',  'zeta' => '950',  'eta' => '951',  'theta' => '952',  'iota' => '953',  'kappa' => '954',
  'lambda' => '955',  'mu' => '956',  'nu' => '957',  'xi' => '958',  'omicron' => '959',  'pi' => '960',  'rho' => '961',  'sigmaf' => '962',
  'sigma' => '963',  'tau' => '964',  'upsilon' => '965',  'phi' => '966',  'chi' => '967',  'psi' => '968',  'omega' => '969',
  'thetasym' => '977',  'upsih' => '978',  'piv' => '982',  'ensp' => '8194',  'emsp' => '8195',  'thinsp' => '8201',  'zwnj' => '8204',
  'zwj' => '8205',  'lrm' => '8206',  'rlm' => '8207',  'ndash' => '8211',  'mdash' => '8212',  'lsquo' => '8216',  'rsquo' => '8217',
  'sbquo' => '8218',  'ldquo' => '8220',  'rdquo' => '8221',  'bdquo' => '8222',  'dagger' => '8224',  'Dagger' => '8225',  'bull' => '8226',
  'hellip' => '8230',  'permil' => '8240',  'prime' => '8242',  'Prime' => '8243',  'lsaquo' => '8249',  'rsaquo' => '8250',  'oline' => '8254',
  'frasl' => '8260',  'euro' => '8364',  'image' => '8465',  'weierp' => '8472',  'real' => '8476',  'trade' => '8482',  'alefsym' => '8501',
  'larr' => '8592',  'uarr' => '8593',  'rarr' => '8594',  'darr' => '8595',  'harr' => '8596',  'crarr' => '8629',  'lArr' => '8656',
  'uArr' => '8657',  'rArr' => '8658',  'dArr' => '8659',  'hArr' => '8660',  'forall' => '8704',  'part' => '8706',  'exist' => '8707',
  'empty' => '8709',  'nabla' => '8711',  'isin' => '8712',  'notin' => '8713',  'ni' => '8715',  'prod' => '8719',  'sum' => '8721',
  'minus' => '8722',  'lowast' => '8727',  'radic' => '8730',  'prop' => '8733',  'infin' => '8734',  'ang' => '8736',  'and' => '8743',
  'or' => '8744',  'cap' => '8745',  'cup' => '8746',  'int' => '8747',  'there4' => '8756',  'sim' => '8764',  'cong' => '8773',
  'asymp' => '8776',  'ne' => '8800',  'equiv' => '8801',  'le' => '8804',  'ge' => '8805',  'sub' => '8834',  'sup' => '8835',  'nsub' => '8836',
  'sube' => '8838',  'supe' => '8839',  'oplus' => '8853',  'otimes' => '8855',  'perp' => '8869',  'sdot' => '8901',  'lceil' => '8968',
  'rceil' => '8969',  'lfloor' => '8970',  'rfloor' => '8971',  'lang' => '9001',  'rang' => '9002',  'loz' => '9674',  'spades' => '9824',
  'clubs' => '9827',  'hearts' => '9829',  'diams' => '9830',
 );
	foreach($entarr AS $key => $val) {
		$this->entsearch[] = '&'.$key.';';
		$this->entsubstitute[] = code2utf($val);
	}
}

function SubstituteHiEntities($html) {
	// converts html_entities > ASCII 127 to unicode (defined in includes/pdf/config.php
	// Leaves in particular &lt; to distinguish from tag marker
	if (count($this->entsearch)) {
		$html = str_replace($this->entsearch,$this->entsubstitute,$html);
	}
	return $html;
}


// Edited v1.2 Pass by reference; option to continue if invalid UTF-8 chars
function is_utf8(&$string) {
	if ($string === mb_convert_encoding(mb_convert_encoding($string, "UTF-32", "UTF-8"), "UTF-8", "UTF-32")) {
		return true;
	} 
	else {
	  if ($this->ignore_invalid_utf8) {
		$string = mb_convert_encoding(mb_convert_encoding($string, "UTF-32", "UTF-8"), "UTF-8", "UTF-32") ;
		return true;
	  }
	  else {
		return false;
	  }
	}
} 


function purify_utf8($html,$lo=true) {
	// For HTML
	// Checks string is valid UTF-8 encoded
	// converts html_entities > ASCII 127 to UTF-8
	// Only exception - leaves low ASCII entities e.g. &lt; &amp; etc.
	// Leaves in particular &lt; to distinguish from tag marker
	if (!$this->is_utf8($html)) { 
		// mPDF 5.0
		echo "<p><b>HTML contains invalid UTF-8 character(s)</b></p>"; 
		while (mb_convert_encoding(mb_convert_encoding($html, "UTF-32", "UTF-8"), "UTF-8", "UTF-32") != $html) {
			$a = iconv('UTF-8', 'UTF-8', $html);
			echo ($a);
			$pos = $start = strlen($a);
			$err = '';
			while ( ord(substr($html,$pos,1)) > 128 ) {
				$err .= '[[#'.ord(substr($html,$pos,1)).']]';
				$pos++;
			}
			echo '<span style="color:red; font-weight:bold">'.$err.'</span>';
			$html = substr($html, $pos);
		}
		echo $html;
		$this->Error(""); 
	}
	$html = preg_replace("/\r/", "", $html );

	// converts html_entities > ASCII 127 to UTF-8 
	// Leaves in particular &lt; to distinguish from tag marker
	$html = $this->SubstituteHiEntities($html);

	// converts all &#nnn; or &#xHHH; to UTF-8 multibyte
	// If $lo==true then includes ASCII < 128
	$html = strcode2utf($html,$lo);
	return ($html);
}

function purify_utf8_text($txt) {
	// For TEXT
	// Make sure UTF-8 string of characters
	if (!$this->is_utf8($txt)) { $this->Error("Text contains invalid UTF-8 character(s)"); }

	$txt = preg_replace("/\r/", "", $txt );

	return ($txt);
}
function all_entities_to_utf8($txt) {
	// converts txt_entities > ASCII 127 to UTF-8 
	// Leaves in particular &lt; to distinguish from tag marker
	$txt = $this->SubstituteHiEntities($txt);

	// converts all &#nnn; or &#xHHH; to UTF-8 multibyte
	$txt = strcode2utf($txt);

	$txt = $this->lesser_entity_decode($txt);
	return ($txt);
}


// ====================================================

// ====================================================
// ====================================================

		// START TRANSFORMATIONS SECTION -----------------------
		// authors: Moritz Wagner, Andreas Wurmser, Nicola Asuni
		// From TCPDF
		// Starts a 2D tranformation saving current graphic state.
		function StartTransform($returnstring=false) {
		  if ($returnstring) { return('q'); }
		  else { $this->_out('q'); }
		}
		function StopTransform($returnstring=false) {
		  if ($returnstring) { return('Q'); }
		  else { $this->_out('Q'); }
		}
		// Vertical and horizontal non-proportional Scaling.
		function transformScale($s_x, $s_y, $x='', $y='', $returnstring=false) {
			if ($x === '') {
				$x=$this->x;
			}
			if ($y === '') {
				$y=$this->y;
			}
			if (($s_x == 0) OR ($s_y == 0)) {
				$this->Error('Please do not use values equal to zero for scaling');
			}
			$y = ($this->h - $y) * $this->k;
			$x *= $this->k;
			//calculate elements of transformation matrix
			$s_x /= 100;
			$s_y /= 100;
			$tm[0] = $s_x;
			$tm[1] = 0;
			$tm[2] = 0;
			$tm[3] = $s_y;
			$tm[4] = $x * (1 - $s_x);
			$tm[5] = $y * (1 - $s_y);
			//scale the coordinate system
			if ($returnstring) { return($this->_transform($tm, true)); }
			else { $this->_transform($tm); }
		}
		// Translate graphic object horizontally and vertically.
		function transformTranslate($t_x, $t_y, $returnstring=false) {
			//calculate elements of transformation matrix
			$tm[0] = 1;
			$tm[1] = 0;
			$tm[2] = 0;
			$tm[3] = 1;
			$tm[4] = $t_x * $this->k;
			$tm[5] = -$t_y * $this->k;
			//translate the coordinate system
			if ($returnstring) { return($this->_transform($tm, true)); }
			else { $this->_transform($tm); }
		}
		// Rotate object.
		function transformRotate($angle, $x='', $y='', $returnstring=false) {
			if ($x === '') {
				$x=$this->x;
			}
			if ($y === '') {
				$y=$this->y;
			}
			$angle = -$angle;
			$y = ($this->h - $y) * $this->k;
			$x *= $this->k;
			//calculate elements of transformation matrix
			$tm[0] = cos(deg2rad($angle));
			$tm[1] = sin(deg2rad($angle));
			$tm[2] = -$tm[1];
			$tm[3] = $tm[0];
			$tm[4] = $x + $tm[1] * $y - $tm[0] * $x;
			$tm[5] = $y - $tm[0] * $y - $tm[1] * $x;
			//rotate the coordinate system around ($x,$y)
			if ($returnstring) { return($this->_transform($tm, true)); }
			else { $this->_transform($tm); }
		}
		function _transform($tm, $returnstring=false) {
			if ($returnstring) { return(sprintf('%.3f %.3f %.3f %.3f %.3f %.3f cm', $tm[0], $tm[1], $tm[2], $tm[3], $tm[4], $tm[5])); }
			else { $this->_out(sprintf('%.3f %.3f %.3f %.3f %.3f %.3f cm', $tm[0], $tm[1], $tm[2], $tm[3], $tm[4], $tm[5])); }
		}
		// END TRANSFORMATIONS SECTION -------------------------




// AUTOFONT =========================
function AutoFont($html) {
	if ($this->usingCoreFont) { return $html; }
	$this->useLang = true;
	if ($this->autoFontGroupSize == 1) { $extra = $this->pregASCIIchars1; }
	else if ($this->autoFontGroupSize == 3) { $extra = $this->pregASCIIchars3; }
	else {  $extra = $this->pregASCIIchars2; }
	$n = '';
	$a=preg_split('/<(.*?)>/ms',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	foreach($a as $i => $e) {
	   if($i%2==0) {
		$e = strcode2utf($e);
		$e = $this->lesser_entity_decode($e);

		// Use U=FFF0 and U+FFF1 to mark start and end of span tags to prevent nesting occurring
		// "\xef\xbf\xb0" ##lthtmltag## "\xef\xbf\xb1" ##gthtmltag##


		// CJK
		if ($this->autoFontGroups & AUTOFONT_CJK) {
			$e = preg_replace("/([".$this->pregCJKchars.$extra."]*[".$this->pregCJKchars."][".$this->pregCJKchars.$extra."]*)/ue", '$this->replaceCJK(stripslashes(\'\\1\'))', $e);
		}





		if ($this->autoFontGroups & AUTOFONT_THAIVIET) {
			// THAI
			$e = preg_replace("/([\x{0E00}-\x{0E7F}".$extra."]*[\x{0E00}-\x{0E7F}][\x{0E00}-\x{0E7F}".$extra."]*)/u", "\xef\xbf\xb0span lang=\"th\"\xef\xbf\xb1\\1\xef\xbf\xb0/span\xef\xbf\xb1", $e);
			// Vietnamese
			$e = preg_replace("/([".$this->pregVIETchars .$this->pregVIETPluschars ."]*[".$this->pregVIETchars ."][".$this->pregVIETchars .$this->pregVIETPluschars ."]*)/u", "\xef\xbf\xb0span lang=\"vi\"\xef\xbf\xb1\\1\xef\xbf\xb0/span\xef\xbf\xb1", $e);
		}

		$e = preg_replace('/[&]/','&amp;',$e);
		$e = preg_replace('/[<]/','&lt;',$e);
		$e = preg_replace('/[>]/','&gt;',$e);
		$e = preg_replace("/(\xef\xbf\xb0span lang=\"([a-z\-A-Z]{2,5})\"\xef\xbf\xb1)\s+/",' \\1',$e);
		$e = preg_replace("/[ ]+(\xef\xbf\xb0\/span\xef\xbf\xb1)/",'\\1 ',$e);

		$e = preg_replace("/\xef\xbf\xb0span lang=\"([a-z\-A-Z]{2,5})\"\xef\xbf\xb1/","\xef\xbf\xb0span lang=\"\\1\" class=\"lang_\\1\"\xef\xbf\xb1",$e);

		$e = preg_replace("/\xef\xbf\xb0/",'<',$e);
		$e = preg_replace("/\xef\xbf\xb1/",'>',$e);

		$a[$i] = $e;
	   }
	   else {
		$a[$i] = '<'.$e.'>'; 
	   }
	}
	$n = implode('',$a);
	return $n;
}



function replaceCJK($str) {
	// Use U=FFF0 and U+FFF1 to mark start and end of span tags to prevent nesting occurring
	// "\xef\xbf\xb0" ##lthtmltag## "\xef\xbf\xb1" ##gthtmltag##
	if (preg_match("/[".$this->pregUHCchars."]/u", $str)) { 
		return "\xef\xbf\xb0span lang=\"ko\"\xef\xbf\xb1" . $str ."\xef\xbf\xb0/span\xef\xbf\xb1";
	}
	else if (preg_match("/[".$this->pregSJISchars."]/u", $str)) { 
		return "\xef\xbf\xb0span lang=\"ja\"\xef\xbf\xb1" . $str ."\xef\xbf\xb0/span\xef\xbf\xb1";
	}
	// if in Unicode Plane 2, probably HKCS (incl in BIG5) if not Japanese
	else if (preg_match("/[\x{20000}-\x{2FFFF}]/u", $str)) { 
		return "\xef\xbf\xb0span lang=\"zh-HK\"\xef\xbf\xb1" . $str ."\xef\xbf\xb0/span\xef\xbf\xb1";
	}
	else{ 
		return "\xef\xbf\xb0span lang=\"zh-CN\"\xef\xbf\xb1" . $str ."\xef\xbf\xb0/span\xef\xbf\xb1";
	}
	return $str;
}




// mPDF 5.0
function _getMQR() {
	$mqr=ini_get("magic_quotes_runtime");
	if (PHP_VERSION_ID < 50300) { return @get_magic_quotes_runtime(); }
	else { return 0; }
}

//===========================
// Functions originally in htmltoolkit - moved mPDF 4.0

// Call-back function Used for usort in fn _tableWrite

function _cmpdom($a, $b) {
    return ($a["dom"] < $b["dom"]) ? -1 : 1;
}

function mb_strrev($str, $enc = 'utf-8'){
	$ch = array();
	$ch = preg_split('//u',$str);
	$revch = array_reverse($ch);
	return implode('',$revch);
}


// Callback function from function printdivbuffer in mpdf - keeping block together on one page
function blockAdjust($type,$k,$xadj,$yadj,$a,$b,$c=0,$d=0,$e=0,$f=0) {
   if ($type == 'Td') { 	// xpos,ypos
	$a += ($xadj * $k);
	$b -= ($yadj * $k);
	return 'BT '.sprintf('%.3f %.3f',$a,$b).' Td'; 
   }
   else if ($type == 're') { 	// xpos,ypos,width,height
	$a += ($xadj * $k);
	$b -= ($yadj * $k);
	return sprintf('%.3f %.3f %.3f %.3f',$a,$b,$c,$d).' re'; 
   }
   else if ($type == 'l') { 	// xpos,ypos,x2pos,y2pos
	$a += ($xadj * $k);
	$b -= ($yadj * $k);
	return sprintf('%.3f %.3f l',$a,$b); 
   }
   else if ($type == 'img') { 	// width,height,xpos,ypos
	$c += ($xadj * $k);
	$d -= ($yadj * $k);
	return sprintf('q %.3f 0 0 %.3f %.3f %.3f',$a,$b,$c,$d).' cm /'.$e;  
   }
   else if ($type == 'draw') { 	// xpos,ypos
	$a += ($xadj * $k);
	$b -= ($yadj * $k);
	return sprintf('%.3f %.3f m',$a,$b); 
   }
   else if ($type == 'bezier') { 	// xpos,ypos,x2pos,y2pos,x3pos,y3pos
	$a += ($xadj * $k);
	$b -= ($yadj * $k);
	$c += ($xadj * $k);
	$d -= ($yadj * $k);
	$e += ($xadj * $k);
	$f -= ($yadj * $k);
	return sprintf('%.3f %.3f %.3f %.3f %.3f %.3f',$a,$b,$c,$d,$e,$f).' c'; 
   }
}

function ConvertColor($color="#000000"){
  //returns an associative array (keys: R,G,B) from html code (e.g. #3FE5AA)
  //All color names array
  static $common_colors = array('antiquewhite'=>'#FAEBD7','aqua'=>'#00FFFF','aquamarine'=>'#7FFFD4','beige'=>'#F5F5DC','black'=>'#000000',
'blue'=>'#0000FF','brown'=>'#A52A2A','cadetblue'=>'#5F9EA0','chocolate'=>'#D2691E','cornflowerblue'=>'#6495ED','crimson'=>'#DC143C',
'darkblue'=>'#00008B','darkgoldenrod'=>'#B8860B','darkgreen'=>'#006400','darkmagenta'=>'#8B008B','darkorange'=>'#FF8C00',
'darkred'=>'#8B0000','darkseagreen'=>'#8FBC8F','darkslategray'=>'#2F4F4F','darkviolet'=>'#9400D3','deepskyblue'=>'#00BFFF',
'dodgerblue'=>'#1E90FF','firebrick'=>'#B22222','forestgreen'=>'#228B22','fuchsia'=>'#FF00FF','gainsboro'=>'#DCDCDC','gold'=>'#FFD700',
'gray'=>'#808080','green'=>'#008000','greenyellow'=>'#ADFF2F','hotpink'=>'#FF69B4','indigo'=>'#4B0082','khaki'=>'#F0E68C',
'lavenderblush'=>'#FFF0F5','lemonchiffon'=>'#FFFACD','lightcoral'=>'#F08080','lightgoldenrodyellow'=>'#FAFAD2','lightgreen'=>'#90EE90',
'lightsalmon'=>'#FFA07A','lightskyblue'=>'#87CEFA','lightslategray'=>'#778899','lightyellow'=>'#FFFFE0','lime'=>'#00FF00','limegreen'=>'#32CD32',
'magenta'=>'#FF00FF','maroon'=>'#800000','mediumaquamarine'=>'#66CDAA','mediumorchid'=>'#BA55D3','mediumseagreen'=>'#3CB371',
'mediumspringgreen'=>'#00FA9A','mediumvioletred'=>'#C71585','midnightblue'=>'#191970','mintcream'=>'#F5FFFA','moccasin'=>'#FFE4B5','navy'=>'#000080',
'olive'=>'#808000','orange'=>'#FFA500','orchid'=>'#DA70D6','palegreen'=>'#98FB98',
'palevioletred'=>'#D87093','peachpuff'=>'#FFDAB9','pink'=>'#FFC0CB','powderblue'=>'#B0E0E6','purple'=>'#800080',
'red'=>'#FF0000','royalblue'=>'#4169E1','salmon'=>'#FA8072','seagreen'=>'#2E8B57','sienna'=>'#A0522D','silver'=>'#C0C0C0','skyblue'=>'#87CEEB',
'slategray'=>'#708090','springgreen'=>'#00FF7F','steelblue'=>'#4682B4','tan'=>'#D2B48C','teal'=>'#008080','thistle'=>'#D8BFD8','turquoise'=>'#40E0D0',
'violetred'=>'#D02090','white'=>'#FFFFFF','yellow'=>'#FFFF00', 
'aliceblue'=>'#f0f8ff', 'azure'=>'#f0ffff', 'bisque'=>'#ffe4c4', 'blanchedalmond'=>'#ffebcd', 'blueviolet'=>'#8a2be2', 'burlywood'=>'#deb887', 
'chartreuse'=>'#7fff00', 'coral'=>'#ff7f50', 'cornsilk'=>'#fff8dc', 'cyan'=>'#00ffff', 'darkcyan'=>'#008b8b', 'darkgray'=>'#a9a9a9', 
'darkgrey'=>'#a9a9a9', 'darkkhaki'=>'#bdb76b', 'darkolivegreen'=>'#556b2f', 'darkorchid'=>'#9932cc', 'darksalmon'=>'#e9967a', 
'darkslateblue'=>'#483d8b', 'darkslategrey'=>'#2f4f4f', 'darkturquoise'=>'#00ced1', 'deeppink'=>'#ff1493', 'dimgray'=>'#696969', 
'dimgrey'=>'#696969', 'floralwhite'=>'#fffaf0', 'ghostwhite'=>'#f8f8ff', 'goldenrod'=>'#daa520', 'grey'=>'#808080', 'honeydew'=>'#f0fff0', 
'indianred'=>'#cd5c5c', 'ivory'=>'#fffff0', 'lavender'=>'#e6e6fa', 'lawngreen'=>'#7cfc00', 'lightblue'=>'#add8e6', 'lightcyan'=>'#e0ffff', 
'lightgray'=>'#d3d3d3', 'lightgrey'=>'#d3d3d3', 'lightpink'=>'#ffb6c1', 'lightseagreen'=>'#20b2aa', 'lightslategrey'=>'#778899', 
'lightsteelblue'=>'#b0c4de', 'linen'=>'#faf0e6', 'mediumblue'=>'#0000cd', 'mediumpurple'=>'#9370db', 'mediumslateblue'=>'#7b68ee', 
'mediumturquoise'=>'#48d1cc', 'mistyrose'=>'#ffe4e1', 'navajowhite'=>'#ffdead', 'oldlace'=>'#fdf5e6', 'olivedrab'=>'#6b8e23', 'orangered'=>'#ff4500', 
'palegoldenrod'=>'#eee8aa', 'paleturquoise'=>'#afeeee', 'papayawhip'=>'#ffefd5', 'peru'=>'#cd853f', 'plum'=>'#dda0dd', 'rosybrown'=>'#bc8f8f', 
'saddlebrown'=>'#8b4513', 'sandybrown'=>'#f4a460', 'seashell'=>'#fff5ee', 'slateblue'=>'#6a5acd', 'slategrey'=>'#708090', 'snow'=>'#fffafa', 
'tomato'=>'#ff6347', 'violet'=>'#ee82ee', 'wheat'=>'#f5deb3', 'whitesmoke'=>'#f5f5f5', 'yellowgreen'=>'#9acd32');
  //http://www.w3schools.com/css/css_colornames.asp
  if (strtoupper($color)=='TRANSPARENT') { return false; }
  if (strtoupper($color)=='INHERIT') { return false; }

  if (isset($common_colors[strtolower($color)])) $color = $common_colors[strtolower($color)];

  if ($color[0] == '#') //case of #nnnnnn or #nnn
  {
  	$cor = strtoupper($color);
	$cor = preg_replace('/\s+.*/','',$cor);	// in case of Background: #CCC url() x-repeat etc.
  	if (strlen($cor) == 4) { // Turn #RGB into #RRGGBB
	 	  $cor = "#" . $cor[1] . $cor[1] . $cor[2] . $cor[2] . $cor[3] . $cor[3];
	}  
	$R = substr($cor, 1, 2);
	$vermelho = hexdec($R);
	$V = substr($cor, 3, 2);
	$verde = hexdec($V);
	$B = substr($cor, 5, 2);
	$azul = hexdec($B);
	$color = array();
	$color['R']=$vermelho;
	$color['G']=$verde;
	$color['B']=$azul;
  }
  else if (stristr($color,'cmyk(')) {	//case of CMYK(c,m,y,k)
	$color = str_replace("cmyk(",'',$color); //remove Ôcmyk(Ô
	$color = str_replace("CMYK(",'',$color); //remove ÔCMYK(Ô 
	$color = str_replace(")",'',$color); //remove Ô)Ô
	$cores = explode(",", $color);
	$color = array();
	$color['R']=$cores[0];
	$color['G']=$cores[1];
	$color['B']=$cores[2];
	$color['K']=$cores[3];
  }
  else if (stristr($color,'rgb(')) //case of RGB(r,g,b)
  {
	$color = str_replace("rgb(",'',$color); //remove Ôrgb(Ô
	$color = str_replace("RGB(",'',$color); //remove ÔRGB(Ô -- PHP < 5 does not have str_ireplace
	$color = str_replace(")",'',$color); //remove Ô)Ô
	$cores = explode(",", $color);
	$color = array();
	$color['R']=$cores[0];
	$color['G']=$cores[1];
	$color['B']=$cores[2];
  }
  else { return false; }
  if (empty($color)) return false;
  else return $color; // array['R']['G']['B']
}

function ConvertSize($size=5,$maxsize=0,$fontsize=false,$usefontsize=true){
// usefontsize - setfalse for e.g. margins - will ignore fontsize for % values
// Depends of maxsize value to make % work properly. Usually maxsize == pagewidth
// For text $maxsize = Fontsize
// Setting e.g. margin % will use maxsize (pagewidth) and em will use fontsize
  //Identify size (remember: we are using 'mm' units here)
  if ( strtolower($size) == 'thin' ) $size = 1*(25.4/$this->dpi); //1 pixel width for table borders
  elseif ( strtolower($size) == 'medium' ) $size = 3*(25.4/$this->dpi); //3 pixel width for table borders
  elseif ( strtolower($size) == 'thick' ) $size = 5*(25.4/$this->dpi); //5 pixel width for table borders
  elseif ( stristr($size,'px') ) $size *= (25.4/$this->dpi); //pixels
  elseif ( stristr($size,'cm') ) $size *= 10; //centimeters
  elseif ( stristr($size,'mm') ) $size += 0; //millimeters
  elseif ( stristr($size,'in') ) $size *= 25.4; //inches 
  elseif ( stristr($size,'pc') ) $size *= 38.1/9; //PostScript picas 
  elseif ( stristr($size,'pt') ) $size *= 25.4/72; //72 pts/inch
  elseif ( stristr($size,'ex') ) {	// Approximates "ex" as half of font height
  	$size += 0; //make "3.5ex" become simply "3.5" 
	if ($fontsize) { $size *= $fontsize/2; }
	else { $size *= $maxsize/2; }
  }
  elseif ( stristr($size,'em') ) {
  	$size += 0; //make "0.83em" become simply "0.83" 
	if ($fontsize) { $size *= $fontsize; }
	else { $size *= $maxsize; }
  }
  elseif ( stristr($size,'%') ) {
  	$size += 0; //make "90%" become simply "90" 
	if ($fontsize && $usefontsize) { $size *= $fontsize/100; }
	else { $size *= $maxsize/100; }
  }
  elseif (strtoupper($size) == 'XX-SMALL') {
	if ($fontsize) { $size *= $fontsize*0.7; }
	else { $size *= $maxsize*0.7; }
  }
  elseif (strtoupper($size) == 'X-SMALL') {
	if ($fontsize) { $size *= $fontsize*0.77; }
	else { $size *= $maxsize*0.77; }
  }
  elseif (strtoupper($size) == 'SMALL') {
	if ($fontsize) { $size *= $fontsize*0.86; }
	else { $size *= $maxsize*0.86; }
  }
  elseif (strtoupper($size) == 'MEDIUM') {
	if ($fontsize) { $size *= $fontsize; }
	else { $size *= $maxsize; }
  }
  elseif (strtoupper($size) == 'LARGE') {
	if ($fontsize) { $size *= $fontsize*1.2; }
	else { $size *= $maxsize*1.2; }
  }
  elseif (strtoupper($size) == 'X-LARGE') {
	if ($fontsize) { $size *= $fontsize*1.5; }
	else { $size *= $maxsize*1.5; }
  }
  elseif (strtoupper($size) == 'XX-LARGE') {
	if ($fontsize) { $size *= $fontsize*2; }
	else { $size *= $maxsize*2; }
  }
  else $size *= (25.4/$this->dpi); //nothing == px
  
  return $size;
}


function lesser_entity_decode($html) {
  //supports the most used entity codes (only does ascii safe characters)
 	$html = str_replace("&nbsp;"," ",$html);
 	$html = str_replace("&lt;","<",$html);
 	$html = str_replace("&gt;",">",$html);

 	$html = str_replace("&apos;","'",$html);
 	$html = str_replace("&quot;",'"',$html);
 	$html = str_replace("&amp;","&",$html);
	return $html;
}

function AdjustHTML($html,$directionality='ltr',$usepre=true, $tabSpaces=8) {
	//Try to make the html text more manageable (turning it into XHTML)

	//Remove javascript code from HTML (should not appear in the PDF file)
	$html = preg_replace('/<script.*?<\/script>/is','',$html);

	//Remove special comments
	$html = preg_replace('/<!--mpdf/i','',$html);
	$html = preg_replace('/mpdf-->/i','',$html);

	//Remove comments from HTML (should not appear in the PDF file)
	$html = preg_replace('/<!--.*?-->/s','',$html);

	$html = preg_replace('/\f/','',$html); //replace formfeed by nothing
	$html = preg_replace('/\r/','',$html); //replace carriage return by nothing

	// Well formed XHTML end tags
	$html = preg_replace('/<(br|hr)\/>/i',"<\\1 />",$html);

	$html = preg_replace("/[ ]*<dottab\s*[\/]*>[ ]*/",'<dottab />',$html);

	// Concatenates any Substitute characters from symbols/dingbats
	$html = str_replace('</tts><tts>','|',$html);
	$html = str_replace('</ttz><ttz>','|',$html);
	$html = str_replace('</tta><tta>','|',$html);

	$html = mb_eregi_replace('/<br \/>\s*/is',"<br />",$html);
	if ($usepre) //used to keep \n on content inside <pre> and inside <textarea>
 	{
		// Preserve '\n's in content between the tags <pre> and </pre>
		$thereispre = preg_match_all('#<pre(.*?)>(.*?)</pre>#si',$html,$temp);
		// Preserve '\n's in content between the tags <textarea> and </textarea>
		$thereistextarea = preg_match_all('#<textarea(.*?)>(.*?)</textarea>#si',$html,$temp2);
		$html = preg_replace('/[\n]/',' ',$html); //replace linefeed by spaces
		$html = preg_replace('/[\t]/',' ',$html); //replace tabs by spaces

		// Converts < to &lt; when not a tag
		$html = preg_replace('/<([^!\/a-zA-Z])/i','&lt;\\1',$html);
		// mPDF changed to prevent &nbsp; chars replaced
		$html = preg_replace("/[ ]+/",' ',$html);

		$html = preg_replace('/\/li>\s+<\/(u|o)l/i','/li></\\1l',$html);
		$html = preg_replace('/\/(u|o)l>\s+<\/li/i','/\\1l></li',$html);
		$html = preg_replace('/\/li>\s+<\/(u|o)l/i','/li></\\1l',$html);
		$html = preg_replace('/\/li>\s+<li/i','/li><li',$html);
		$html = preg_replace('/<(u|o)l([^>]*)>[ ]+/i','<\\1l\\2>',$html);
		$html = preg_replace('/[ ]+<(u|o)l/i','<\\1l',$html);

		$iterator = 0;
		while($thereispre) //Recover <pre attributes>content</pre>
		{
			$temp[2][$iterator] = str_replace("<||@mpdf@||pre", "<pre", $temp[2][$iterator] );
			$temp[2][$iterator] = str_replace("<||@mpdf@||/pre", "</pre", $temp[2][$iterator] );
			$temp[2][$iterator] = preg_replace("/^([^\n\t]*?)\t/me", "stripslashes('\\1') . str_repeat(' ',  ( $tabSpaces - (mb_strlen(stripslashes('\\1')) % $tabSpaces))  )",$temp[2][$iterator]);

			$temp[2][$iterator] = preg_replace('/&/',"&amp;",$temp[2][$iterator]);
			$temp[2][$iterator] = preg_replace('/</',"&lt;",$temp[2][$iterator]);

			$temp[2][$iterator] = preg_replace('/\t/',str_repeat(" ",$tabSpaces),$temp[2][$iterator]);

			$temp[2][$iterator] = preg_replace('/\n/',"<br />",$temp[2][$iterator]);
			$html = preg_replace('#<pre(.*?)>(.*?)</pre>#si','<erp'.$temp[1][$iterator].'>'.$temp[2][$iterator].'</erp>',$html,1);
			$thereispre--;
			$iterator++;
		}
		$iterator = 0;
		while($thereistextarea) //Recover <textarea attributes>content</textarea>
		{
			$temp2[2][$iterator] = preg_replace('/&/',"&amp;",$temp2[2][$iterator]);
			$temp2[2][$iterator] = preg_replace('/</',"&lt;",$temp2[2][$iterator]);

			$temp2[2][$iterator] = preg_replace('/\t/',str_repeat(" ",$tabSpaces),$temp2[2][$iterator]);
			$temp2[2][$iterator] = preg_replace('/[ ]/',"&nbsp;",$temp2[2][$iterator]);
			$html = preg_replace('#<textarea(.*?)>(.*?)</textarea>#si','<aeratxet'.$temp2[1][$iterator].'>'.trim($temp2[2][$iterator]) .'</aeratxet>',$html,1);
			$thereistextarea--;
			$iterator++;
		}
		//Restore original tag names
		$html = str_replace("<erp","<pre",$html);
		$html = str_replace("</erp>","</pre>",$html);
		$html = str_replace("<aeratxet","<textarea",$html);
		$html = str_replace("</aeratxet>","</textarea>",$html);
		// (the code above might slowdown overall performance?)
	} //end of if($usepre)
	else
	{
		$html = preg_replace('/\n/',' ',$html); //replace linefeed by spaces
		$html = preg_replace('/\t/',' ',$html); //replace tabs by spaces

		// Converts < to &lt; when not a tag
		$html = preg_replace('/<([^!\/a-zA-Z])/i','&lt;\\1',$html);
		// mPDF changed to prevent &nbsp; chars replaced
		$html = preg_replace("/[ ]+/",' ',$html);

		$html = preg_replace('/\/li>\s+<\/(u|o)l/i','/li></\\1l',$html);
		$html = preg_replace('/\/(u|o)l>\s+<\/li/i','/\\1l></li',$html);
		$html = preg_replace('/\/li>\s+<\/(u|o)l/i','/li></\\1l',$html);
		$html = preg_replace('/\/li>\s+<li/i','/li><li',$html);
		$html = preg_replace('/<(u|o)l([^>]*)>[ ]+/i','<\\1l\\2>',$html);
		$html = preg_replace('/[ ]+<(u|o)l/i','<\\1l',$html);

	}
	$html = preg_replace('/<textarea([^>]*)><\/textarea>/si','<textarea\\1> </textarea>',$html);
	$html = preg_replace("/\xbb\xa4\xac/", "\n", $html);
	return $html;
}



//===========================


}//end of Class




?>
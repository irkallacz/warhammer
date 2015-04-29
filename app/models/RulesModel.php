<?php
/**
 * RulesModel base class.
 */
class RulesModel extends Nette\Object
{	
	public $dir;

	public function __construct($dir){
		$this->dir = $dir;
	}
	
  public function safe_path($path){
    return str_replace(' ','_',mb_strtolower($path));
  }

  public function nice_path($path){
    return str_replace('_',' ',ucfirst($path));
  }
  
  public function XSLTransform($path,DOMDocument $xml){ 
    $xsl = new DOMDocument;
    $xsl->load($path);
    
    $proc = new XSLTProcessor;
    $proc->importStyleSheet($xsl);
    return $proc->transformToXML($xml);
  }    

  public function getPrehled($name,$warband){
   $unit = $this->getXMLFile($name, $warband, true);
   return $this->XSLTransform($this->dir.'wargear_prehled.xsl', $unit);
  }
  
  public function getPravidla($name,$warband,$sets){
    $unit = $this->getXMLRules($name,$warband,$sets);            
    return $this->XSLTransform($this->dir.'unit_html.xsl', $unit);
  }

  public function getPdf($name,$warband,$sets){
    $unit = $this->getXMLRules($name,$warband,$sets);            
    return $this->XSLTransform($this->dir.'unit_pdf.xsl', $unit);
  }  
  
  public function getXMLFile($name, $warband, $extend = false){
    $path = $this->dir.$this->safe_path($warband.'/'.$name);
    if ($extend) $path.= '_wargear.xml'; else $path.= '.xml';    
  
    $xml = new DOMDocument;
    $xml->load($path);
    return $xml;
  }    

  public function getNodeFromRules($name, $unit, $warband){
    $xml = simplexml_import_dom($this->getXMLFile($unit,$warband,true));
    $result = $xml->xpath("/wargear/*/*[name = '$name']");
    $node['points'] = (int) $result[0]->points[0];
    $node['cond'] = (string) $result[0]->cond[0];

    return $node; 
  }

  public function getConditionsFromNode($unit,$warband){
      $xml = simplexml_import_dom($this->getXMLFile($unit,$warband,true));
      
      $condition = array();      
      foreach($xml->xpath('/wargear/*/*')as $node) $condition[(string) $node->name] = (string) ($node->cond);
      
      return $condition;
  }

  public function getXMLRules($name, $warband,array $sets = array()){                
    $unit = $this->getXMLFile($name, $warband);
        
    /*Pokud sets není prázné*/
    if (!empty($sets)) {  
        /*Otevřeme wargear*/
        $wargear = $this->getXMLFile($name, $warband, true);
        $xpath = new DOMXPath($wargear);
       
        /*Přidat položky v poli $sets*/
        foreach($sets as $in){
          /*Najdeme nadžezenou položku*/
          
          $node = $xpath->query("/wargear/*/*[name='$in']")->item(0);   
          $parent_name = $node->parentNode->tagName;
          
          /*Pokud neexistuje nadřazená kategorie, tak jí vytvoří*/
          if (!$unit->getElementsByTagName($parent_name)->length) {
            $new = $unit->createElement($parent_name);
            $parent = $unit->documentElement->appendChild($new);
          } else $parent = $unit->getElementsByTagName($parent_name)->item(0);
          
          /*Přidá položku z wargearu do svého místa v pravidlech*/
          $import = $unit->importNode($node, true); 
          $parent->appendChild($import);
        }
      unset($wargaer);
      unset($xpath);
      }
    return $unit;
  }
}
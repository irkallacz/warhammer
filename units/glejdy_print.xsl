<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" indent="yes" encoding="utf-8"/>
<xsl:param name="basePath" select="'http://www.warhammer-tos.cz/'" />
<xsl:param name="nick" select="'Nick'" />
<xsl:key name="nodes" match="/jednotka/pravidla/*" use="name()"/>

<xsl:template match="jednotka">
  <h2><xsl:value-of select="$nick"/></h2> 
  <h2><xsl:value-of select="jmeno"/></h2>
  
  <ul id="pravidla">
  <xsl:for-each select="pravidla/*">
    <xsl:variable name="node" select="name()" />
    <xsl:variable name="pocet" select="sum(/jednotka/*/*/*[name()=$node]|.)"/>
    <xsl:if test="$pocet">
      <li><xsl:value-of select="$pocet"/>&#160;<xsl:value-of select="key('nodes',$node)/@label"/>
      <xsl:if test="$node='lives'">
        <xsl:if test="/jednotka/hiearchie/text()='core'"> (6)</xsl:if>
        <xsl:if test="/jednotka/hiearchie/text()='rare'"> (8)</xsl:if>
        <xsl:if test="/jednotka/hiearchie/text()='hero'"> (10)</xsl:if>
      </xsl:if>
      </li>
    </xsl:if>
  </xsl:for-each>
  </ul>

  <xsl:if test="zbrane/zbran">
    <div class="out zbrane">
    <xsl:for-each select="zbrane/zbran">
      <h3><xsl:value-of select="name"/></h3>
    </xsl:for-each>
    </div>  
  </xsl:if> 

  <xsl:if test="zbroje/zbroj">
    <div class="out zbroje">
    <xsl:for-each select="zbroje/zbroj">
      <h3><xsl:value-of select="name"/></h3>
    </xsl:for-each>
    </div>  
  </xsl:if> 

  <xsl:if test="vybaveni/vybava">
    <div class="out vybaveni">
    <xsl:for-each select="vybaveni/vybava">
      <h3><xsl:value-of select="name"/></h3>
    </xsl:for-each>
    </div>  
  </xsl:if> 
    
  <xsl:if test="schopnosti/skill">
    <div class="out schopnosti">
    <xsl:for-each select="schopnosti/skill">
      <h3><xsl:value-of select="name"/></h3>
    </xsl:for-each>
    </div>  
  </xsl:if> 
  
  <xsl:if test="kouzla/spell"> 
    <div class="out kouzla">
    <xsl:for-each select="kouzla/spell"> 
      <h3><xsl:value-of select="name"/></h3> 
    </xsl:for-each>
    </div>
  </xsl:if>
  
</xsl:template>
     
</xsl:stylesheet> 
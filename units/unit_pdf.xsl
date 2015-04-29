<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" indent="yes" encoding="utf-8" doctype-public="-//W3C//DTD HTML 4.01//EN" />
<xsl:param name="basePath" select="'http://warhammer.irkalla.cz/'" />
<xsl:key name="nodes" match="/jednotka/pravidla/*" use="name()"/>

<xsl:template match="jednotka">

<html>
  <body>
  <head>
  <pageheader name="WarHeader" content-left="Warhammer - The Othet Sides IV"  content-right="Pravidla 2012" header-style="color: rgb(112,112,112)" />
  <pagefooter name="WarFooter" content-center="Copyright © DDarkA 2012 All Rights Reserved" footer-style="color: rgb(112,112,112)" />
  
  <setpageheader name="WarHeader" value="on" show-this-page="1" />
  <setpagefooter name="WarFooter" value="on" />
  </head>
    
  <p id="head"><img alt="Warhammer - The Other Sides IV" src="{$basePath}img/unit_top_pdf.gif"/></p> 

  <h1><xsl:value-of select="jmeno"/></h1>

  <h2>Legenda:<bookmark content="Legenda" /></h2>
  <p id="legenda"><xsl:value-of select="legenda"/></p>  

  <h2>Hiearchie:<bookmark content="Hiearchie" /></h2>
  <p id="hiearchie"><xsl:value-of select="hiearchie"/></p>  

  <h2>Popis:<bookmark content="Popis" /></h2>
  <p id="popis"><xsl:value-of select="popis"/></p>

  <h2>Kostým:<bookmark content="Kostým" /></h2>
  <div id="kostym">
  <p><b>Povinné: </b> <xsl:value-of select="kostym/povinne"/></p>
  <p><b>Extra: </b> <xsl:value-of select="kostym/extra"/></p>
  </div>

  <h2>Zbraně:<bookmark content="Zbraně" /></h2>
  <div id="zbrane" class="seznam">
  <xsl:apply-templates select="zbrane/zbran"/>
  </div>
  
  <xsl:if test="zbroje/zbroj">
  <h2>Zbroje:<bookmark content="Zbroje" /></h2>
  <div id="zbroje" class="seznam">
  <xsl:apply-templates select="zbroje/zbroj"/>
  </div>
  </xsl:if>

  <xsl:if test="vybaveni/vybava">
  <h2>Vybaveni:<bookmark content="Vybavení" /></h2>
  <div id="vybaveni" class="seznam">
  <xsl:apply-templates select="vybaveni/vybava"/>
  </div>
  </xsl:if>
    
  <h2>Pravidla:<bookmark content="Pravidla" /></h2>
  <div id="pravidla" class="seznam">
  <xsl:for-each select="pravidla/*">
    <xsl:variable name="node" select="name()" />
    <xsl:variable name="pocet" select="sum(/jednotka/*/*/*[name()=$node]|.)"/>
    <xsl:if test="$pocet">
      <div><xsl:value-of select="$pocet"/>&#160;<xsl:value-of select="key('nodes',$node)/@label"/>
      <xsl:if test="$node='lives'">
        <xsl:if test="/jednotka/hiearchie/text()='core'"> (6)</xsl:if>
        <xsl:if test="/jednotka/hiearchie/text()='rare'"> (8)</xsl:if>
        <xsl:if test="/jednotka/hiearchie/text()='hero'"> (10)</xsl:if>
      </xsl:if>
      </div>
    </xsl:if>
  </xsl:for-each>
  </div>

  <xsl:if test="povolani/path">
    <h2>Povolani:<bookmark content="Povolání" /></h2>
    <div id="povolani" class="seznam">
    <xsl:apply-templates select="povolani/path"/>
    </div>
  </xsl:if>
  
  <xsl:if test="schopnosti/skill">
    <h2>Schopnosti:<bookmark content="Schopnosti" /></h2>    
    <div class="out schopnosti">
    <xsl:for-each select="schopnosti/skill">
      <h3><xsl:value-of select="name"/>
      <bookmark level="1"><xsl:attribute name="content"><xsl:value-of select="name"/></xsl:attribute></bookmark> 
      <span class="attr"> (<xsl:value-of select="attr"/>)</span></h3>
      <p><xsl:copy-of select="desc"/> 
      <xsl:for-each select="*"><xsl:if test="key('nodes',name())"><span class="plus">&#10019;</span></xsl:if></xsl:for-each>
      </p>
    </xsl:for-each>
    </div>  
  </xsl:if> 
  
  <xsl:if test="kouzla/spell"> 
    <h2>Kouzla:<bookmark content="Kouzla" /></h2>
    <p><xsl:copy-of select="kouzla/desc"/></p>
    <div class="out kouzla">
    <xsl:for-each select="kouzla/spell"> 
      <h3><xsl:value-of select="name"/> 
      <bookmark level="1"><xsl:attribute name="content"><xsl:value-of select="name"/></xsl:attribute></bookmark>
      <span class="attr"> (<xsl:value-of select="attr"/>, <xsl:value-of select="cost"/>)</span></h3>
      <p><xsl:copy-of select="desc"/></p>
      <p class="formule"><xsl:value-of select="form"/></p> 
    </xsl:for-each>
    </div>
  </xsl:if>
  
  <h2>Roleplay:<bookmark content="Roleplay" /></h2>
  <p id="roleplay"><xsl:value-of select="roleplay"/></p>
  
  </body>
</html>
</xsl:template>

<xsl:template match="zbran|zbroj|path|vybava"> 
  <div><strong><xsl:value-of select="name"/></strong> - <xsl:copy-of select="desc" />
  <xsl:for-each select="*">
    <xsl:if test="key('nodes',name())"><span class="plus">&#10019;</span></xsl:if>
  </xsl:for-each>
  </div>
</xsl:template>
    
</xsl:stylesheet> 
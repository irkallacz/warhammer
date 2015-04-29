<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" indent="yes" encoding="utf-8"/>
<xsl:param name="basePath" select="'http://www.warhammer-tos.cz/'" />
<xsl:param name="nick" select="'Nick'" />
<xsl:key name="nodes" match="/jednotka/pravidla/*" use="name()"/>

<xsl:template match="jednotka">

  <h2><xsl:value-of select="$nick"/> - <xsl:value-of select="jmeno"/></h2>
  
   <!-- <h2>Pravidla:</h2> -->
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


<!--   <h2>Kostým:</h2> -->
  <div id="kostym" class="seznam">
  <p><b>Povinné: </b> <xsl:value-of select="kostym/povinne"/></p>
  <p><b>Extra: </b> <xsl:value-of select="kostym/extra"/></p>
  </div>

  <xsl:if test="povolani/path">
    <!-- <h2>Povolani:</h2> -->
    <ul id="povolani" class="seznam">
      <xsl:apply-templates select="povolani/path"/>
    </ul>
  </xsl:if>
  
  <!-- <h2>Zbraně:</h2> -->
  <ul id="zbrane" class="seznam">
    <xsl:apply-templates select="zbrane/zbran"/>
  </ul>
  
  <xsl:if test="zbroje/zbroj">
  <!-- <h2>Zbroje:</h2> -->
  <ul id="zbroje" class="seznam">
    <xsl:apply-templates select="zbroje/zbroj"/>
  </ul>
  </xsl:if>

  <xsl:if test="vybaveni/vybava">
  <!-- <h2>Vybaveni:</h2> -->
  <ul id="vybaveni" class="seznam">
    <xsl:apply-templates select="vybaveni/vybava"/>
  </ul>
  </xsl:if>
    
  <xsl:if test="schopnosti/skill">
    <!-- <h2>Schopnosti:</h2>    --> 
    <div class="out schopnosti">
    <xsl:for-each select="schopnosti/skill">
      <h3><xsl:value-of select="name"/> <span class="attr"> (<xsl:value-of select="attr"/>)</span></h3>
      <p><xsl:apply-templates select="desc"/>
      <xsl:for-each select="*">
        <xsl:if test="key('nodes',name())">
          <xsl:call-template name="plus"><xsl:with-param name="id"><xsl:value-of select="name()"/></xsl:with-param></xsl:call-template>
        </xsl:if>
      </xsl:for-each>
      </p>
    </xsl:for-each>
    </div>  
  </xsl:if> 
  
  <xsl:if test="kouzla/spell"> 
    <!-- <h2>Kouzla:</h2> -->
    <p class="desc"><b>Magie: </b> <xsl:apply-templates select="kouzla/desc"/></p>
    <div class="out kouzla">
    <xsl:for-each select="kouzla/spell"> 
      <h3><xsl:value-of select="name"/> <span class="attr"> (<xsl:value-of select="attr"/>, <xsl:value-of select="cost"/>)</span></h3>
      <p><xsl:apply-templates select="desc"/></p>
      <p class="formule"><xsl:value-of select="form"/></p> 
    </xsl:for-each>
    </div>
  </xsl:if>
  
</xsl:template>

<xsl:template match="zbran|zbroj|path|vybava"> 
  <li><strong><xsl:value-of select="name"/></strong> - <xsl:apply-templates select="desc"/>
  <xsl:for-each select="*">
    <xsl:if test="key('nodes',name())">
    <xsl:call-template name="plus"><xsl:with-param name="id"><xsl:value-of select="name()"/></xsl:with-param></xsl:call-template>
    </xsl:if>
  </xsl:for-each>
  </li>
</xsl:template>

<xsl:template name="plus"> 
  <xsl:param name="id"/>
  <span class="plus">
    <xsl:attribute name="title">Změna počtu <xsl:value-of select="key('nodes',$id)/@label"/> byla započítana</xsl:attribute>
    &#10019;
  </span>  
</xsl:template>

<xsl:template match="desc"> 
  <xsl:apply-templates select="text()|b|i|u|cite|br"/>  
</xsl:template>

<xsl:template match="b|i|u|cite"> 
  <xsl:element name="{name()}">
    <xsl:value-of select="."/>
  </xsl:element>  
</xsl:template>

<xsl:template match="br"><br /></xsl:template>
     
</xsl:stylesheet> 
<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" indent="yes" encoding="utf-8" />

<xsl:key name="polozky" match="/wargear/*/*" use="cond"/>

<xsl:template match="wargear">      
  <ul><xsl:apply-templates select="*/*[not(cond)]"/></ul>
</xsl:template>

<xsl:template match="*"> 
  <xsl:param name="id" select="name"/>
  <li>
    <a class="{concat('elem ',name())}" href="#{name}"><xsl:value-of select="name" /></a>
    <xsl:if test="key('polozky',$id)"><ul><xsl:apply-templates select="key('polozky',$id)"/></ul></xsl:if>
  </li>
</xsl:template>
     
</xsl:stylesheet> 
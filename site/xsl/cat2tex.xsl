<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="cat">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="atomic">
		<xsl:text>\cat</xsl:text>
		<xsl:value-of select="."/>
		<xsl:if test="@feature">
			<xsl:text>[</xsl:text>
			<xsl:value-of select="@feature"/>
			<xsl:text>]</xsl:text>
		</xsl:if>
	</xsl:template>
	<xsl:template match="forward">
		<xsl:if test="name(parent::*) != 'cat'">
			<xsl:text>(</xsl:text>
		</xsl:if>
		<xsl:apply-templates select="*[1]"/>
		<xsl:text>/</xsl:text>
		<xsl:apply-templates select="*[2]"/>
		<xsl:if test="name(parent::*) != 'cat'">
			<xsl:text>)</xsl:text>
		</xsl:if>
	</xsl:template>
	<xsl:template match="backward">
		<xsl:if test="name(parent::*) != 'cat'">
			<xsl:text>(</xsl:text>
		</xsl:if>
		<xsl:apply-templates select="*[1]"/>
		<xsl:text>\?</xsl:text>
		<xsl:apply-templates select="*[2]"/>
		<xsl:if test="name(parent::*) != 'cat'">
			<xsl:text>)</xsl:text>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>

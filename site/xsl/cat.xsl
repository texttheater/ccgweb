<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE xsl:stylesheet>
<!-- Transforms XML representations of CCG categories to text
representations -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="cat">
		<xsl:apply-templates select="atomic|forward|backward"/>
	</xsl:template>

	<xsl:template match="atomic">
		<xsl:value-of select="."/>
		<xsl:if test="@feature">
			<xsl:text>[</xsl:text>
			<xsl:value-of select="@feature"/>
			<xsl:text>]</xsl:text>
		</xsl:if>
	</xsl:template>

	<xsl:template match="forward">
		<xsl:param name="embedded" select="0"/>
		<xsl:if test="$embedded = 1">
			<xsl:text>(</xsl:text>
		</xsl:if>
		<xsl:apply-templates select="*[1]">
			<xsl:with-param name="embedded" select="1"/>
		</xsl:apply-templates>
		<xsl:text>/</xsl:text>
		<xsl:apply-templates select="*[2]">
			<xsl:with-param name="embedded" select="1"/>
		</xsl:apply-templates>
		<xsl:if test="$embedded = 1">
			<xsl:text>)</xsl:text>
		</xsl:if>
	</xsl:template>

	<xsl:template match="backward">
		<xsl:param name="embedded" select="0"/>
		<xsl:if test="$embedded = 1">
			<xsl:text>(</xsl:text>
		</xsl:if>
		<xsl:apply-templates select="*[1]">
			<xsl:with-param name="embedded" select="1"/>
		</xsl:apply-templates>
		<xsl:text>\</xsl:text>
		<xsl:apply-templates select="*[2]">
			<xsl:with-param name="embedded" select="1"/>
		</xsl:apply-templates>
		<xsl:if test="$embedded = 1">
			<xsl:text>)</xsl:text>
		</xsl:if>
	</xsl:template>

</xsl:stylesheet>

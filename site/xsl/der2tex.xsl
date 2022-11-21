<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="cat2tex.xsl"/>
	<xsl:output method="text" encoding="UTF-8"/>
	<xsl:strip-space elements="*"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="lexlist">
		<xsl:text>\begin{tikzpicture}[ampersand replacement=\&amp;]&#xA;</xsl:text>
		<xsl:text>	\matrix [column sep=9pt] at (0, 0) {&#xA;</xsl:text>
		<xsl:apply-templates mode="lexlist"/>
		<xsl:text>	};&#xA;</xsl:text>
		<xsl:text>\end{tikzpicture}</xsl:text>
	</xsl:template>
	<xsl:template match="lex" mode="lexlist">
		<!-- TODO escape for TeX -->
		<xsl:text>		\ccgword{</xsl:text>
		<xsl:value-of select="generate-id()"/>
		<xsl:text>}{</xsl:text>
		<xsl:value-of select="token"/>
		<xsl:text>}</xsl:text>
		<xsl:choose>
			<xsl:when test="position() = last()">
				<xsl:text> \\&#xA;</xsl:text>
			</xsl:when>
			<xsl:otherwise>
				<xsl:text> \&amp;&#xA;
				</xsl:text>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="der">
		<xsl:text>\begin{tikzpicture}[ampersand replacement=\&amp;]&#xA;</xsl:text>
		<xsl:text>	\matrix [column sep=9pt] at (0, 0) {&#xA;</xsl:text>
		<xsl:apply-templates select=".//lex"/>
		<xsl:text>	};&#xA;</xsl:text>
		<xsl:apply-templates select="binaryrule|unaryrule"/>
		<xsl:text>\end{tikzpicture}</xsl:text>
	</xsl:template>
	<xsl:template match="lex">
		<!-- TODO escape for TeX -->
		<xsl:text>		\lexnode*{</xsl:text>
		<xsl:value-of select="generate-id()"/>
		<xsl:text>}{</xsl:text>
		<xsl:value-of select="token"/>
		<xsl:text>}{</xsl:text>
		<xsl:apply-templates select="cat"/>
		<xsl:text>}{}</xsl:text>
		<xsl:choose>
			<xsl:when test="position() = last()">
				<xsl:text> \\&#xA;</xsl:text>
			</xsl:when>
			<xsl:otherwise>
				<xsl:text> \&amp;&#xA;</xsl:text>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="unaryrule">
		<xsl:apply-templates select="binaryrule|unaryrule"/>
		<xsl:text>	\unnode*{</xsl:text>
		<xsl:value-of select="generate-id()"/>
		<xsl:text>}{</xsl:text>
		<xsl:value-of select="generate-id((binaryrule|unaryrule|lex)[1])"/>
		<xsl:text>}{</xsl:text>
		<xsl:choose>
			<xsl:when test="@type = 'ftr'">\FTR</xsl:when>
			<xsl:when test="@type = 'ftr'">\BTR</xsl:when>
			<xsl:otherwise>*</xsl:otherwise>
		</xsl:choose>
		<xsl:text>}{</xsl:text>
		<xsl:apply-templates select="cat"/>
		<xsl:text>}{}&#xA;</xsl:text>
	</xsl:template>
	<xsl:template match="binaryrule">
		<xsl:apply-templates select="binaryrule|unaryrule"/>
		<xsl:variable name="child1" select="(binaryrule|unaryrule|lex)[1]"/>
		<xsl:variable name="child2" select="(binaryrule|unaryrule|lex)[2]"/>
		<xsl:text>	\binnode*{</xsl:text>
		<xsl:value-of select="generate-id()"/>
		<xsl:text>}{</xsl:text>
		<xsl:value-of select="generate-id($child1)"/>
		<xsl:if test="name($child1) = 'lex'">-cat</xsl:if>
		<xsl:text>}{</xsl:text>
		<xsl:value-of select="generate-id($child2)"/>
		<xsl:if test="name($child2) = 'lex'">-cat</xsl:if>
		<xsl:text>}{</xsl:text>
		<xsl:choose>
			<xsl:when test="@type='fa'">\FC{0}</xsl:when>
			<xsl:when test="@type='fc'">\FC{1}</xsl:when>
			<xsl:when test="@type='gfc'">\FC{n}</xsl:when>
			<xsl:when test="@type='gbc'">\BC{n}</xsl:when>
			<xsl:when test="@type='bc'">\BC{1}</xsl:when>
			<xsl:when test="@type='conj'">\wedge</xsl:when>
			<xsl:when test="@type='bxc'">\BXC{1}</xsl:when>
			<xsl:when test="@type='fxc'">\FXC{1}</xsl:when>
			<xsl:when test="@type='gbxc'">\BXC{n}</xsl:when>
			<xsl:when test="@type='gfxc'">\FXC{n}</xsl:when>
			<xsl:when test="@type='ba'">\BC{0}</xsl:when>
			<xsl:when test="@type='rp'">.</xsl:when>
			<xsl:when test="@type='lp'">.</xsl:when>
		</xsl:choose>
		<xsl:text>}{</xsl:text>
		<xsl:apply-templates select="cat"/>
		<xsl:text>}{}&#xA;</xsl:text>
	</xsl:template>
</xsl:stylesheet>

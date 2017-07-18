<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="cat.xsl"/>
	<xsl:param name="standalone" select="'no'"/>
	<xsl:output method="html" encoding="UTF-8"/>
	<xsl:template match="/">
		<xsl:choose>
			<xsl:when test="$standalone = 'yes'">
				<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html&gt;</xsl:text>
				<html>
					<head>
						<title>Derivations</title>
						<link rel="stylesheet" type="text/css" href="css/der.css"/>
					</head>
					<body>
						<main>
							<xsl:apply-templates/>
						</main>
					</body>
				</html>
			</xsl:when>
			<xsl:otherwise>
				<xsl:apply-templates/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="der">
		<div class="der">
			<xsl:apply-templates/>
		</div>
	</xsl:template>
	<xsl:template match="binaryrule">
		<table class="constituent binaryrule">
			<tr class="daughters">
				<td class="daughter daughter-left">
					<xsl:apply-templates select="(binaryrule|unaryrule|lex)[1]"/>
				</td>
				<td class="daughter daughter-right">
					<xsl:apply-templates select="(binaryrule|unaryrule|lex)[2]"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="rulecat">
					<xsl:element name="span">
						<xsl:attribute name="class">rule</xsl:attribute>
						<xsl:attribute name="title"><xsl:value-of select="@description"/></xsl:attribute>
						<xsl:choose>
							<xsl:when test="@type='fa'">&gt;</xsl:when>
							<xsl:when test="@type='fc'">&gt;B</xsl:when>
							<xsl:when test="@type='gfc'">&gt;B<span style="vertical-align: super;">n</span></xsl:when>
							<xsl:when test="@type='gbc'">&lt;B<span style="vertical-align: super;">n</span></xsl:when>
							<xsl:when test="@type='bc'">&lt;B</xsl:when>
							<xsl:when test="@type='fs'">&gt;S</xsl:when>
							<xsl:when test="@type='bs'">&lt;S</xsl:when>
							<xsl:when test="@type='conj'">&#8744;</xsl:when>
							<xsl:when test="@type='bxc'">&lt;</xsl:when>
							<xsl:when test="@type='fxc'">&gt;</xsl:when>
							<xsl:when test="@type='gbxc'">&lt;<span style="vertical-align: super;">n</span></xsl:when>
							<xsl:when test="@type='gfxc'">&gt;<span style="vertical-align: super;">n</span></xsl:when>
							<xsl:when test="@type='fxs'">&gt;</xsl:when>
							<xsl:when test="@type='bxs'">&lt;</xsl:when>
							<xsl:when test="@type='ba'">&lt;</xsl:when>
						</xsl:choose>
					</xsl:element>
					<xsl:element name="span">
						<xsl:attribute name="class">cat</xsl:attribute>
						<xsl:apply-templates select="cat"/>
					</xsl:element>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="unaryrule">
		<table class="constituent unaryrule">
			<tr class="daughters">
				<td class="daughter daughter-only">
					<xsl:apply-templates select="(binaryrule|unaryrule|lex)[1]"/>
				</td>
			</tr>
			<tr>
				<xsl:element name="td">
					<xsl:attribute name="class">rule</xsl:attribute>
					<xsl:attribute name="title"><xsl:value-of select="@description"/></xsl:attribute>
					<xsl:choose>
						<xsl:when test="@type='tc'">*</xsl:when>
						<xsl:when test="@type='ftr'">&gt;T</xsl:when>
						<xsl:when test="@type='btr'">&lt;T</xsl:when>
					</xsl:choose>
				</xsl:element>
			</tr>
			<tr>
				<td class="cat">
					<xsl:apply-templates select="cat"/>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="lex">
		<xsl:element name="table">
			<xsl:attribute name="class">constituent lex</xsl:attribute>
			<xsl:attribute name="data-token">
				<xsl:value-of select="token"/>
			</xsl:attribute>
			<xsl:attribute name="data-from">
				<xsl:value-of select="tag[@type='from']"/>
			</xsl:attribute>
			<xsl:attribute name="data-to">
				<xsl:value-of select="tag[@type='to']"/>
			</xsl:attribute>
			<tr>
				<td class="token">
					<xsl:value-of select="token"/>
				</td>
			</tr>
			<tr>
				<td class="cat">
					<xsl:apply-templates select="cat"/>
				</td>
			</tr>
			<tr>
				<td class="spanconstraint-selectable">&#160;</td>
			</tr>
		</xsl:element>
	</xsl:template>
</xsl:stylesheet>

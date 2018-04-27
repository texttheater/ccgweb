<p>Unlike CCGrebank, we use normal CCG categories for conjunctions. We still
give a right-branching analysis. For example:</p>

<div class=der>
	<table class="constituent binaryrule">
		<tr class="daughters">
			<td class="daughter daughter-left">
				<table class=lex>
					<tr>
						<td class="token">He</td>
					</tr>
					<tr>
						<td class="cat">NP</td>
					</tr>
				</table>
			</td>
			<td class="daughter daughter-right">
				<table class="constituent binaryrule">
					<tr class="daughters">
						<td class="daughter daughter-left">
							<table class=lex>
								<tr>
									<td class="token">cried</td>
								</tr>
								<tr>
									<td class="cat">S[dcl]\NP</td>
								</tr>
							</table>
						</td>
						<td class="daughter daughter-right">
							<table class="constituent binaryrule">
								<tr class="daughters">
									<td class="daughter daughter-left">
										<table class=lex>
											<tr>
												<td class="token">and</td>
											</tr>
											<tr>
												<td class="cat">((S[dcl]\NP)\(S[dcl]\NP))/(S[dcl]\NP)</td>
											</tr>
										</table>
									</td>
									<td class="daughter daughter-right">
										<table class=lex>
											<tr>
												<td class="token">laughed</td>
											</tr>
											<tr>
												<td class="cat">S[dcl]\NP</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class="rulecat" colspan=2>
										<div class="rulecat">
											<div class="cat">(S[dcl]\NP)\(S[dcl]\NP)</div>
											<div class="rule" title="Forward Application">&gt;<sup>0</sup></div>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="rulecat" colspan=2>
							<div class="rulecat">
								<div class="cat">S[dcl]\NP</div>
								<div class="rule" title="Backward Application">&lt;<sup>0</sup></div>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="rulecat" colspan=2>
				<div class="rulecat">
					<div class="cat">S[dcl]</div>
					<div class="rule" title="Backward Application">&lt;<sup>0</sup></div>
				</div>
			</td>
		</tr>
	</table>
</div>

<p>When constituents of different categories are coordinated, the left one determines the
category of the result:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[b]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[b]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Schweig" data-from="0" data-to="7" data-cat="S[b]\NP">
<tr><td class="token">Schweig</td></tr>
<tr><td class="cat" tabindex="0">S[b]\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="(S[b]\NP)\(S[b]\NP)">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="((S[b]\NP)\(S[b]\NP))/S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="," data-from="7" data-to="8" data-cat="(((S[b]\NP)\(S[b]\NP))/S[dcl])/(((S[b]\NP)\(S[b]\NP))/S[dcl])">
<tr><td class="token">,</td></tr>
<tr><td class="cat" tabindex="0">(((S[b]\NP)\(S[b]\NP))/S[dcl])/(((S[b]\NP)\(S[b]\NP))/S[dcl])</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="oder" data-from="9" data-to="13" data-cat="((S[b]\NP)\(S[b]\NP))/S[dcl]">
<tr><td class="token">oder</td></tr>
<tr><td class="cat" tabindex="0">((S[b]\NP)\(S[b]\NP))/S[dcl]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">((S[b]\NP)\(S[b]\NP))/S[dcl]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="ich" data-from="14" data-to="17" data-cat="NP">
<tr><td class="token">ich</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="explodiere" data-from="18" data-to="28" data-cat="S[dcl]\NP">
<tr><td class="token">explodiere</td></tr>
<tr><td class="cat" tabindex="0">S[dcl]\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">(S[b]\NP)\(S[b]\NP)</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[b]\NP</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="!" data-from="28" data-to="29" data-cat="(S[b]\NP)\(S[b]\NP)">
<tr><td class="token">!</td></tr>
<tr><td class="cat" tabindex="0">(S[b]\NP)\(S[b]\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[b]\NP</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

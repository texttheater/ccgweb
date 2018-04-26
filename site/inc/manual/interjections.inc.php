<p>We deal here with interjections like <i>yes</i>, <i>no</i> and <i>please</i>
and their foreign-language equivalents.</p>

<p>When forming a complete utterances by themselves, these have category <code>S[intj]</code>:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[intj]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Please" data-from="0" data-to="6" data-cat="S[intj]">
<tr><td class="token">Please</td></tr>
<tr><td class="cat" tabindex="0">S[intj]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="!" data-from="6" data-to="7" data-cat="S[intj]\S[intj]">
<tr><td class="token">!</td></tr>
<tr><td class="cat" tabindex="0">S[intj]\S[intj]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[intj]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

<p>Likewise if they appear as the object of a speech verb (treat them as direct
speech even if there are no quotation marks):</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[b]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[b]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Say" data-from="0" data-to="3" data-cat="(S[b]\NP)/S[intj]">
<tr><td class="token">Say</td></tr>
<tr><td class="cat" tabindex="0">(S[b]\NP)/S[intj]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="yes" data-from="4" data-to="7" data-cat="S[intj]">
<tr><td class="token">yes</td></tr>
<tr><td class="cat" tabindex="0">S[intj]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[b]\NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="!" data-from="7" data-to="8" data-cat="(S[b]\NP)\(S[b]\NP)">
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

<p>If they appear next to a another sentence, VP, or NP, treat them as
modifiers:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[b]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Please" data-from="0" data-to="6" data-cat="(S\NP)/(S\NP)">
<tr><td class="token">Please</td></tr>
<tr><td class="cat" tabindex="0">(S\NP)/(S\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="stay" data-from="7" data-to="11" data-cat="S[b]\NP">
<tr><td class="token">stay</td></tr>
<tr><td class="cat" tabindex="0">S[b]\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[b]\NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

 <div class="der">
<table class="constituent binaryrule" data-cat="NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent unaryrule" data-cat="NP">
<tr class="daughters"><td class="daughter daughter-only"><table class="constituent lex" data-token="Caffè" data-from="0" data-to="5" data-cat="N">
<tr><td class="token">Caffè</td></tr>
<tr><td class="cat" tabindex="0">N</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td></tr>
<tr><td class="rulecat"><div class="rulecat">
<div class="cat">NP</div>
<div class="rule" title="Type Changing">
									*
								</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="NP\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="," data-from="5" data-to="6" data-cat="(NP\NP)/(NP\NP)">
<tr><td class="token">,</td></tr>
<tr><td class="cat" tabindex="0">(NP\NP)/(NP\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="NP\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="per" data-from="7" data-to="10" data-cat="(NP\NP)/NP">
<tr><td class="token">per</td></tr>
<tr><td class="cat" tabindex="0">(NP\NP)/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent unaryrule" data-cat="NP">
<tr class="daughters"><td class="daughter daughter-only"><table class="constituent lex" data-token="favore" data-from="11" data-to="17" data-cat="N">
<tr><td class="token">favore</td></tr>
<tr><td class="cat" tabindex="0">N</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td></tr>
<tr><td class="rulecat"><div class="rulecat">
<div class="cat">NP</div>
<div class="rule" title="Type Changing">
									*
								</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">NP\NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">NP\NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">NP</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

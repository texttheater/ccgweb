<p>Yes/no questions have category <code>S[q]</code>. <i>wh</i>-questions have
category <code>S[wq]</code>. Other utterances have neither of these categories,
even when followed by a question mark. For example:</p>

<div class="der">
<table class="constituent binaryrule" data-cat="S[q]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[q]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[q]/(S[b]\NP)">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Did" data-from="0" data-to="3" data-cat="(S[q]/(S[b]\NP))/NP">
<tr><td class="token">Did</td></tr>
<tr><td class="cat" tabindex="0">(S[q]/(S[b]\NP))/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="you" data-from="4" data-to="7" data-cat="NP">
<tr><td class="token">you</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]/(S[b]\NP)</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="sleep" data-from="8" data-to="13" data-cat="S[b]\NP">
<tr><td class="token">sleep</td></tr>
<tr><td class="cat" tabindex="0">S[b]\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="13" data-to="14" data-cat="S[q]\S[q]">
<tr><td class="token">?</td></tr>
<tr><td class="cat" tabindex="0">S[q]\S[q]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Who" data-from="0" data-to="3" data-cat="S[wq]/S[q]">
<tr><td class="token">Who</td></tr>
<tr><td class="cat" tabindex="0">S[wq]/S[q]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[q]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[q]/(S[b]\NP)">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="did" data-from="4" data-to="7" data-cat="(S[q]/(S[b]\NP))/NP">
<tr><td class="token">did</td></tr>
<tr><td class="cat" tabindex="0">(S[q]/(S[b]\NP))/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="you" data-from="8" data-to="11" data-cat="NP">
<tr><td class="token">you</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]/(S[b]\NP)</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="see" data-from="12" data-to="15" data-cat="S[b]\NP">
<tr><td class="token">see</td></tr>
<tr><td class="cat" tabindex="0">S[b]\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="15" data-to="16" data-cat="S[wq]\S[wq]">
<tr><td class="token">?</td></tr>
<tr><td class="cat" tabindex="0">S[wq]\S[wq]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

 <div class="der">
<table class="constituent binaryrule" data-cat="NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent unaryrule" data-cat="NP">
<tr class="daughters"><td class="daughter daughter-only"><table class="constituent lex" data-token="Marco" data-from="0" data-to="5" data-cat="N">
<tr><td class="token">Marco</td></tr>
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
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="5" data-to="6" data-cat="NP\NP">
<tr><td class="token">?</td></tr>
<tr><td class="cat" tabindex="0">NP\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">NP</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

<p>In Italian, yes/no questions have the same word order as declarative
sentences.  Nevertheless, the verbs have <code>S[q]</code> categories then. Do
not use the question mark to change the category:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[q]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[q]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Vuoi" data-from="0" data-to="4" data-cat="S[q]/(S[b]\NP)">
<tr><td class="token">Vuoi</td></tr>
<tr><td class="cat" tabindex="0">S[q]/(S[b]\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="parlare" data-from="5" data-to="12" data-cat="S[b]\NP">
<tr><td class="token">parlare</td></tr>
<tr><td class="cat" tabindex="0">S[b]\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="12" data-to="13" data-cat="S[q]\S[q]">
<tr><td class="token">?</td></tr>
<tr><td class="cat" tabindex="0">S[q]\S[q]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

<p><i>wh</i>-phrases representing an extracted subject or predicate noun have
category <code>S[wq]/(S[dcl]\NP)</code>:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Who" data-from="0" data-to="3" data-cat="S[wq]/(S[dcl]\NP)">
<tr><td class="token">Who</td></tr>
<tr><td class="cat" tabindex="0">S[wq]/(S[dcl]\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[dcl]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="'s" data-from="3" data-to="5" data-cat="(S[dcl]\NP)/(S[adj]\NP)">
<tr><td class="token">'s</td></tr>
<tr><td class="cat" tabindex="0">(S[dcl]\NP)/(S[adj]\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="there" data-from="6" data-to="11" data-cat="S[adj]\NP">
<tr><td class="token">there</td></tr>
<tr><td class="cat" tabindex="0">S[adj]\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]\NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="11" data-to="12" data-cat="S[wq]\S[wq]">
<tr><td class="token">?</td></tr>
<tr><td class="cat" tabindex="0">S[wq]\S[wq]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="What" data-from="0" data-to="4" data-cat="S[wq]/(S[dcl]\NP)">
<tr><td class="token">What</td></tr>
<tr><td class="cat" tabindex="0">S[wq]/(S[dcl]\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[dcl]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="is" data-from="5" data-to="7" data-cat="(S[dcl]\NP)/NP">
<tr><td class="token">is</td></tr>
<tr><td class="cat" tabindex="0">(S[dcl]\NP)/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="a" data-from="8" data-to="9" data-cat="NP/N">
<tr><td class="token">a</td></tr>
<tr><td class="cat" tabindex="0">NP/N</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="tank" data-from="10" data-to="14" data-cat="N">
<tr><td class="token">tank</td></tr>
<tr><td class="cat" tabindex="0">N</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]\NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="14" data-to="15" data-cat="S[wq]\S[wq]">
<tr><td class="token">?</td></tr>
<tr><td class="cat" tabindex="0">S[wq]\S[wq]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

<p><i>wh</i>-phrases representing another extracted argument have category <code>S[wq]/(S[q]/X)</code> where <code>X</code>
is the category of the extracted argument:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Who" data-from="0" data-to="3" data-cat="S[wq]/(S[q]/NP)">
<tr><td class="token">Who</td></tr>
<tr><td class="cat" tabindex="0">S[wq]/(S[q]/NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[q]/NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[q]/(S[b]\NP)">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="did" data-from="4" data-to="7" data-cat="(S[q]/(S[b]\NP))/NP">
<tr><td class="token">did</td></tr>
<tr><td class="cat" tabindex="0">(S[q]/(S[b]\NP))/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="you" data-from="8" data-to="11" data-cat="NP">
<tr><td class="token">you</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]/(S[b]\NP)</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="see" data-from="12" data-to="15" data-cat="(S[b]\NP)/NP">
<tr><td class="token">see</td></tr>
<tr><td class="cat" tabindex="0">(S[b]\NP)/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]/NP</div>
<div class="rule" title="Forward Composition">&gt; <sup>1</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="15" data-to="16" data-cat="S[wq]\S[wq]">
<tr><td class="token">?</td></tr>
<tr><td class="cat" tabindex="0">S[wq]\S[wq]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Where" data-from="0" data-to="5" data-cat="S[wq]/(S[q]/PP)">
<tr><td class="token">Where</td></tr>
<tr><td class="cat" tabindex="0">S[wq]/(S[q]/PP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[q]/PP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[q]/(S[b]\NP)">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="did" data-from="6" data-to="9" data-cat="(S[q]/(S[b]\NP))/NP">
<tr><td class="token">did</td></tr>
<tr><td class="cat" tabindex="0">(S[q]/(S[b]\NP))/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="you" data-from="10" data-to="13" data-cat="NP">
<tr><td class="token">you</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]/(S[b]\NP)</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="go" data-from="14" data-to="16" data-cat="(S[b]\NP)/PP">
<tr><td class="token">go</td></tr>
<tr><td class="cat" tabindex="0">(S[b]\NP)/PP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]/PP</div>
<div class="rule" title="Forward Composition">&gt; <sup>1</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="16" data-to="17" data-cat="S[wq]\S[wq]">
<tr><td class="token">?</td></tr>
<tr><td class="cat" tabindex="0">S[wq]\S[wq]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

<p><i>wh</i>-phrases representing an extracted modifier have category <code>S[wq]/S[q]</code>:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[wq]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="How" data-from="0" data-to="3" data-cat="S[wq]/S[q]">
<tr><td class="token">How</td></tr>
<tr><td class="cat" tabindex="0">S[wq]/S[q]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[q]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[q]/(S[b]\NP)">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="did" data-from="4" data-to="7" data-cat="(S[q]/(S[b]\NP))/NP">
<tr><td class="token">did</td></tr>
<tr><td class="cat" tabindex="0">(S[q]/(S[b]\NP))/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="you" data-from="8" data-to="11" data-cat="NP">
<tr><td class="token">you</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]/(S[b]\NP)</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[b]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="do" data-from="12" data-to="14" data-cat="(S[b]\NP)/NP">
<tr><td class="token">do</td></tr>
<tr><td class="cat" tabindex="0">(S[b]\NP)/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="that" data-from="15" data-to="19" data-cat="NP">
<tr><td class="token">that</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[b]\NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[q]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="19" data-to="20" data-cat="S[wq]\S[wq]">
<tr><td class="token">?</td></tr>
<tr><td class="cat" tabindex="0">S[wq]\S[wq]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[wq]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

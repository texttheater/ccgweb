<p>As in CCGrebank, pronouns have category <code>NP</code>.</p>

<p>This includes reflexive pronouns. They are treated as regular arguments of
their verbs.</p>

<p>This also includes “dative” pronouns such as <i>mi</i> in <i>Mi piace
viaggiare</i>.</p>

<p>This also includes the Dutch and German generic pronouns <i>men</i> and
<i>man</i>.</p>

<p>Expletive pronouns are marked with the <code>expl</code> feature (thus have
category <code>N[expl]</code>) <b>if and only if</b> they stand in for an
extraposed clausal argument. “Weather pronouns” do not get this feature. Both
the expletive pronoun and the extraposed clause are then arguments of the verb.
For example:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Es" data-from="0" data-to="2" data-cat="NP[expl]">
<tr><td class="token">Es</td></tr>
<tr><td class="cat" tabindex="0">NP[expl]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[dcl]\NP[expl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="(S[dcl]\NP[expl])/S[em]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="ist" data-from="3" data-to="6" data-cat="((S[dcl]\NP[expl])/S[em])/(S[adj]\NP)">
<tr><td class="token">ist</td></tr>
<tr><td class="cat" tabindex="0">((S[dcl]\NP[expl])/S[em])/(S[adj]\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="doof" data-from="7" data-to="11" data-cat="S[adj]\NP">
<tr><td class="token">doof</td></tr>
<tr><td class="cat" tabindex="0">S[adj]\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">(S[dcl]\NP[expl])/S[em]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[em]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="," data-from="11" data-to="12" data-cat="S[em]/S[em]">
<tr><td class="token">,</td></tr>
<tr><td class="cat" tabindex="0">S[em]/S[em]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[em]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="dass" data-from="13" data-to="17" data-cat="S[em]/S[dcl]">
<tr><td class="token">dass</td></tr>
<tr><td class="cat" tabindex="0">S[em]/S[dcl]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="es" data-from="18" data-to="20" data-cat="NP">
<tr><td class="token">es</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="regnet" data-from="21" data-to="27" data-cat="S[dcl]\NP">
<tr><td class="token">regnet</td></tr>
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
<div class="cat">S[em]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[em]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]\NP[expl]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="." data-from="27" data-to="28" data-cat="S[dcl]\S[dcl]">
<tr><td class="token">.</td></tr>
<tr><td class="cat" tabindex="0">S[dcl]\S[dcl]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>





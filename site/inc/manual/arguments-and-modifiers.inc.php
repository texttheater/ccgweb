<h4>Compound Verbs</h4>

<p>In compound verbs that have a lexical nominal argument, e.g. <i>take care
of</i>, the question arises whether the argument is an argument of the verb
(<i>take</i>) or the noun (<i>care</i>).  We favor verb arguments in these
cases:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[b]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="(S[b]\NP)/PP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="take" data-from="0" data-to="4" data-cat="((S[b]\NP)/PP)/NP">
<tr><td class="token">take</td></tr>
<tr><td class="cat" tabindex="0">((S[b]\NP)/PP)/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent unaryrule" data-cat="NP">
<tr class="daughters"><td class="daughter daughter-only"><table class="constituent lex" data-token="care" data-from="5" data-to="9" data-cat="N">
<tr><td class="token">care</td></tr>
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
<div class="cat">(S[b]\NP)/PP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="PP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="of" data-from="10" data-to="12" data-cat="PP/NP">
<tr><td class="token">of</td></tr>
<tr><td class="cat" tabindex="0">PP/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="him" data-from="13" data-to="16" data-cat="NP">
<tr><td class="token">him</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">PP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[b]\NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

<h4>NPs Acting as Modifiers</h4>

<p>Temporal NPs can act as VP (or sentence) modifiers. Following CCGrebank, if
these NPs consist of an adjective followed by a noun, they are analyzed as in
the following example:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="I" data-from="0" data-to="1" data-cat="NP">
<tr><td class="token">I</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[dcl]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[dcl]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="saw" data-from="2" data-to="5" data-cat="(S[dcl]\NP)/NP">
<tr><td class="token">saw</td></tr>
<tr><td class="cat" tabindex="0">(S[dcl]\NP)/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="her" data-from="6" data-to="9" data-cat="NP">
<tr><td class="token">her</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]\NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="(S\NP)\(S\NP)">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="last" data-from="10" data-to="14" data-cat="((S\NP)\(S\NP))/((S\NP)\(S\NP))">
<tr><td class="token">last</td></tr>
<tr><td class="cat" tabindex="0">((S\NP)\(S\NP))/((S\NP)\(S\NP))</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="week" data-from="15" data-to="19" data-cat="(S\NP)\(S\NP)">
<tr><td class="token">week</td></tr>
<tr><td class="cat" tabindex="0">(S\NP)\(S\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">(S\NP)\(S\NP)</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]\NP</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
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
<td class="daughter daughter-right"><table class="constituent lex" data-token="." data-from="19" data-to="20" data-cat="S[dcl]\S[dcl]">
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

<p>If they consist of a determiner followed by an <code>N</code> expression,
only the determiner gets a non-standard category:</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="L'" data-from="0" data-to="2" data-cat="NP">
<tr><td class="token">L'</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[dcl]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="ho" data-from="2" data-to="4" data-cat="S[dcl]/(S[pt]\NP)">
<tr><td class="token">ho</td></tr>
<tr><td class="cat" tabindex="0">S[dcl]/(S[pt]\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="vista" data-from="5" data-to="10" data-cat="(S[pt]\NP)\NP">
<tr><td class="token">vista</td></tr>
<tr><td class="cat" tabindex="0">(S[pt]\NP)\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]\NP</div>
<div class="rule" title="Forward Crossed Composition">&gt; <sup>1</sup><sub>×</sub>
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
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S\S">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="la" data-from="11" data-to="13" data-cat="(S\S)/N">
<tr><td class="token">la</td></tr>
<tr><td class="cat" tabindex="0">(S\S)/N</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="N">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="settimana" data-from="14" data-to="23" data-cat="N">
<tr><td class="token">settimana</td></tr>
<tr><td class="cat" tabindex="0">N</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="scorsa" data-from="24" data-to="30" data-cat="N\N">
<tr><td class="token">scorsa</td></tr>
<tr><td class="cat" tabindex="0">N\N</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">N</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S\S</div>
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
<td class="daughter daughter-right"><table class="constituent lex" data-token="." data-from="30" data-to="31" data-cat="S[dcl]\S[dcl]">
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

<h4>Direct Speech</h4>

<p>Speech verbs have fully specified argument categories, e.g.,
<code>S[intj]</code> or <code>S[dcl]</code>, not <code>S</code>. For example:</p>

 <div class="der">
<table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token='"' data-from="0" data-to="1">
<tr><td class="token">"</td></tr>
<tr><td class="cat" tabindex="0">S[intj]/S[intj]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Hello" data-from="1" data-to="6">
<tr><td class="token">Hello</td></tr>
<tr><td class="cat" tabindex="0">S[intj]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token='"' data-from="6" data-to="7">
<tr><td class="token">"</td></tr>
<tr><td class="cat" tabindex="0">S[intj]\S[intj]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[intj]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[intj]</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="," data-from="7" data-to="8">
<tr><td class="token">,</td></tr>
<tr><td class="cat" tabindex="0">S[intj]\S[intj]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[intj]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="she" data-from="9" data-to="12">
<tr><td class="token">she</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="said" data-from="13" data-to="17">
<tr><td class="token">said</td></tr>
<tr><td class="cat" tabindex="0">(S[dcl]\S[intj])\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]\S[intj]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">S[dcl]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table> </div>

<h4>Subjects of Auxiliary and Modal Verbs</h4>

<p>In constructions with auxiliary and modal verbs, the subject is an argument
of the auxiliary/modal. Other arguments are arguments of the embedded verb.</p>

<h4>Copulas, Adverbs and Predicative Adjectives</h4>

<p>Adverbials appearing in a copula phrase with an adjective can modify the
adjective or the copula. Degree adverbials such as <i>very</i> modify the
adjective. Quantificational adverbials such as <i>always</i> modify the
copula.</p>

<h4>Dativus commodi</h4>

<p>We treat <i>dativus commodi</i> as part of the verb’s argument structure
(not every verb allows it):</p>

 <div class="der">
<table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="S[dcl]">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="Ich" data-from="0" data-to="3" data-cat="NP">
<tr><td class="token">Ich</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="S[dcl]\NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="(S[dcl]\NP)/NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="kaufe" data-from="4" data-to="9" data-cat="((S[dcl]\NP)/NP)/NP">
<tr><td class="token">kaufe</td></tr>
<tr><td class="cat" tabindex="0">((S[dcl]\NP)/NP)/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="mir" data-from="10" data-to="13" data-cat="NP">
<tr><td class="token">mir</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">(S[dcl]\NP)/NP</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule" data-cat="NP">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="einen" data-from="14" data-to="19" data-cat="NP/N">
<tr><td class="token">einen</td></tr>
<tr><td class="cat" tabindex="0">NP/N</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="Hund" data-from="20" data-to="24" data-cat="N">
<tr><td class="token">Hund</td></tr>
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
<div class="cat">S[dcl]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="." data-from="24" data-to="25" data-cat="S[dcl]\S[dcl]">
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

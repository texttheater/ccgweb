<p>CCGrebank distinguishes different subtypes of the basic <code>S</code>
category with features: <code>[ng]</code> for present participle,
<code>[pt]</code> for past participle, <code>[dcl]</code> for indicative,
<code>[b]</code> for infinitive and imperative, <code>[to]</code> for
<i>to</i>-infinitive, <code>[q]</code> for yes/no questions, <code>[wq]</code>
for <i>wh</i>-questions, <code>[em]</code> for embedded clauses and
<code>[intj]</code> for interjections.</p>

<p>Although this feature set is designed for English and additional
distinctions would make sense for other languages (for example, main vs.
subordinate clause for German and Dutch), the features can in most cases be
applied to our target languages, and we stick with the existing feature set for
now.</p>

<h4>Underspecification</h4>

<p>VP and S modifiers are underspecified for the clause type they modify, using
just plain <code>S</code> categories. For example:</p>

 <div class="der">
<table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="We" data-from="0" data-to="2">
<tr><td class="token">We</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="sang" data-from="3" data-to="7">
<tr><td class="token">sang</td></tr>
<tr><td class="cat" tabindex="0">S[dcl]\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="happily" data-from="8" data-to="15">
<tr><td class="token">happily</td></tr>
<tr><td class="cat" tabindex="0">(S\NP)\(S\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
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
</table> </div>

<p>However, categories in → <a href=<?= url('manual.php', ['section' =>
'punctuation']) ?>>punctuation</a> and <a href=<?= url('manual.php', ['section'
=> 'coordination']) ?>>coordination</a> that modify such constituents do carry
the feature.</p>

<h4>German <i>zu</i></h4>

<p>Be advised that the German morpheme <i>zu</i> marking <code>[to]</code>-type
clauses may be hiding inside a separable verb:</p>

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
<td class="daughter daughter-left"><table class="constituent binaryrule" data-cat="(S[dcl]\NP)/(S[to]\NP)">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="brauche" data-from="4" data-to="11" data-cat="(S[dcl]\NP)/(S[to]\NP)">
<tr><td class="token">brauche</td></tr>
<tr><td class="cat" tabindex="0">(S[dcl]\NP)/(S[to]\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="nicht" data-from="12" data-to="17" data-cat="(S\NP)\(S\NP)">
<tr><td class="token">nicht</td></tr>
<tr><td class="cat" tabindex="0">(S\NP)\(S\NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">(S[dcl]\NP)/(S[to]\NP)</div>
<div class="rule" title="Backward Crossed Composition">&lt; <sup>1</sup><sub>×</sub>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="aufzustehen" data-from="18" data-to="29" data-cat="S[to]\NP">
<tr><td class="token">aufzustehen</td></tr>
<tr><td class="cat" tabindex="0">S[to]\NP</td></tr>
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
<div class="cat">S[dcl]</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="." data-from="29" data-to="30" data-cat="S[dcl]\S[dcl]">
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

<h4>Dutch <i>om</i></h4>

<p>The Dutch equivalent of <i>to</i> is <i>te</i>, but additionally the <i>om</i>
complementizer frequently appears before <code>[to]</code> clauses. We give <i>om</i>
category <code>(S[to]\NP)/(S[to]\NP)</code>.</p>

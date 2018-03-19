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

<p>However, → <a href=<?= url('manual.php',
['section' => 'punctuation']) ?>>punctuation</a> categories that modify such
constituents do carry the feature.</p>

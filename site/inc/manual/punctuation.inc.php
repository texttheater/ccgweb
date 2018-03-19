<p>In a slight departure from CCGrebank, we do not use the special punctuation
categories (<code>,</code>, <code>.</code>, <code>:</code>, <code>;</code>,
<code>LRB</code>, <code>RRB</code>, <code>LQU</code>, <code>RQU</code>) or the
corresponding punctuation rules. Instead, we give punctuation symbols real CCG
modifier categories that, unlike real modifiers, are specified for
→ <a href=<?= url('manual.php', ['section' => 'clause-types']) ?>>clause type</a>.
We combine them with constituents via application.</p>

<h4>Sentence-final Punctuation</h4>

<p>Sentence-final punctuation attaches at the top level. For example:</p>

<div class=der>
	<div class=lexlist>
		<table class=lex>
			<tr>
				<td class="token">Tom</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">sang</td>
			</tr>
			<tr>
				<td class="cat">S[dcl]\NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">.</td>
			</tr>
			<tr>
				<td class="cat">S[dcl]\S[dcl]</td>
			</tr>
		</table>
	</div>
</div>

<h4>Punctuation Separating Head and Modifier</h4>

<p>Puncutation, especially commas, often appears between a head and its
modifier. The rule is then to attach punctuation to the modifier, e.g.,
the subordinate clause. For example:</p>

<div class=der>
	<div class=lexlist>
		<table class=lex>
			<tr>
				<td class="token">Ich</td>
			</tr>
			<tr>
				<td class="cat">NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">will</td>
			</tr>
			<tr>
				<td class="cat">(S[dcl]\NP)/S[em]</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">,</td>
			</tr>
			<tr>
				<td class="cat">S[em]/S[em]</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">dass</td>
			</tr>
			<tr>
				<td class="cat">S[em]/S[dcl]</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">Tom</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">singt</td>
			</tr>
			<tr>
				<td class="cat">S[dcl]\NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">.</td>
			</tr>
			<tr>
				<td class="cat">S[dcl]\S[dcl]</td>
			</tr>
		</table>
	</div>
</div>

<h4>The Oxford Comma</h4>

<p>The Oxford comma attaches to the conjunction before which it appears. For
example:</p>

<div class=der>
	<div class=lexlist>
		<table class=lex>
			<tr>
				<td class="token">Tim</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">,</td>
			</tr>
			<tr>
				<td class="cat">(NP\NP)/NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">Tom</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">,</td>
			</tr>
			<tr>
				<td class="cat">((NP\NP)/NP)/((NP\NP)/NP)</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">and</td>
			</tr>
			<tr>
				<td class="cat">(NP\NP)/NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">Tammy</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
	</div>
</div>

<h4>Commas before Appositions</h4>

<p>Commas before appositions are analyzed like conjunctions in → <a href=<?=
url('manual.php', ['section' => 'coordination']) ?>>coordination</a>. For
example:</p>

<div class=der>
	<div class=lexlist>
		<table class=lex>
			<tr>
				<td class="token">Hans</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">,</td>
			</tr>
			<tr>
				<td class="cat">(NP\NP)/NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">a</td>
			</tr>
			<tr>
				<td class="cat">NP/N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">businessman</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
	</div>
</div>

<h4>Commas Surrounding Appositions</h4>

<p>When an apposition is surrounded by commas, the comma on the right attaches
to the whole noun phrase, including the apposition and its argument:</p>

 <div class="der">
<table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent unaryrule">
<tr class="daughters"><td class="daughter daughter-only"><table class="constituent lex" data-token="Hans" data-from="0" data-to="4">
<tr><td class="token">Hans</td></tr>
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
<td class="daughter daughter-right"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="," data-from="4" data-to="5">
<tr><td class="token">,</td></tr>
<tr><td class="cat" tabindex="0">(NP\NP)/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="a" data-from="6" data-to="7">
<tr><td class="token">a</td></tr>
<tr><td class="cat" tabindex="0">NP/N</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="businessman" data-from="8" data-to="19">
<tr><td class="token">businessman</td></tr>
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
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="," data-from="19" data-to="20">
<tr><td class="token">,</td></tr>
<tr><td class="cat" tabindex="0">NP\NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">NP</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="smokes" data-from="21" data-to="27">
<tr><td class="token">smokes</td></tr>
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
<td class="daughter daughter-right"><table class="constituent lex" data-token="." data-from="27" data-to="28">
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

<h4>Quotes</h4>

<p>Quotation marks surrounding a constituent attach in a right-branching
fashion. For example:</p>

<div class=der>
	<table class="constituent binaryrule">
		<tr class="daughters">
			<td class="daughter daughter-left">
				<table class="constituent binaryrule">
					<tr class="daughters">
						<td class="daughter daughter-left">
							<div class=lexlist>
								<table class=lex>
									<tr>
										<td class="token">They</td>
									</tr>
									<tr>
										<td class="cat">NP</td>
									</tr>
								</table>
								<table class=lex>
									<tr>
										<td class="token">watched</td>
									</tr>
									<tr>
										<td class="cat">(S[dcl]\NP)/NP</td>
									</tr>
								</table>
							</div>
						</td>
						<td class="daughter daughter-right">
							<table class="constituent binaryrule">
								<tr class="daughters">
									<td class="daughter daughter-left">
										<table class=lex>
											<tr>
												<td class="token">&quot;</td>
											</tr>
											<tr>
												<td class="cat">NP/NP</td>
											</tr>
										</table>
									</td>
									<td class="daughter daughter-right">
										<table class="constituent binaryrule">
											<tr class="daughters">
												<td class="daughter daughter-left">
													<table class="constituent unaryrule">
														<tr class="daughters">
															<td class="daughter daughter-only">
																<table class=lex>
																	<tr>
																		<td class="token">Fargo</td>
																	</tr>
																	<tr>
																		<td class="cat">N</td>
																	</tr>
																</table>
															</td>
														</tr>
														<tr>
															<td class="rulecat">
																<div class="rulecat">
																	<div class="cat">NP</div>
																	<div class="rule" title="Type changing">*</div>
																</div>
															</td>
														</tr>
													</table>
												</td>
												<td class="daughter daughter-right">
													<table class=lex>
														<tr>
															<td class="token">&quot;</td>
														</tr>
														<tr>
															<td class="cat">NP\NP</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td class="rulecat" colspan="2">
													<div class="rulecat">
														<div class="cat">NP</div>
														<div class="rule" title="Backward application">&lt;<sup>0</sup></div>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class="rulecat" colspan="2">
										<div class="rulecat">
											<div class="cat">NP</div>
											<div class="rule" title="Forward application">&gt;<sup>0</sup></div>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td class="daughter daughter-right">
				<table class=lex>
					<tr>
						<td class="token">.</td>
					</tr>
					<tr>
						<td class="cat">S[dcl]\S[dcl]</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<h4>Direct Speech</h4>

<p>A sentence that appears as direct speech is treated like a sentential
complement. The quotation marks do not change its category. For example:</p>

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

<h4>Use-mention Conversion</h4>

<p>Other than direct speech, when quotes surround a linguistic expression that
is mentioned, the expression is analyzed as if it was <i>used</i> (even if it
is in another language), then the right quote gets a category that converts the
use category to the mention category (usually <code>NP</code>). For
example:</p>

 <div class="der">
<table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="What" data-from="0" data-to="4">
<tr><td class="token">What</td></tr>
<tr><td class="cat" tabindex="0">S[wq]/(S[q]/NP)</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="does" data-from="5" data-to="9">
<tr><td class="token">does</td></tr>
<tr><td class="cat" tabindex="0">(S[q]/(S[b]\NP))/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token='"' data-from="10" data-to="11">
<tr><td class="token">"</td></tr>
<tr><td class="cat" tabindex="0">NP/NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent binaryrule">
<tr class="daughters">
<td class="daughter daughter-left"><table class="constituent lex" data-token="ti" data-from="11" data-to="13">
<tr><td class="token">ti</td></tr>
<tr><td class="cat" tabindex="0">NP</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="amo" data-from="14" data-to="17">
<tr><td class="token">amo</td></tr>
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
<td class="daughter daughter-right"><table class="constituent lex" data-token='"' data-from="17" data-to="18">
<tr><td class="token">"</td></tr>
<tr><td class="cat" tabindex="0">NP\S[dcl]</td></tr>
<tr><td class="span-swiper"> </td></tr>
</table></td>
</tr>
<tr><td colspan="2" class="rulecat"><div class="rulecat">
<div class="cat">NP</div>
<div class="rule" title="Backward Application">&lt; <sup>0</sup>
</div>
</div></td></tr>
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
<div class="cat">S[q]/(S[b]\NP)</div>
<div class="rule" title="Forward Application">&gt; <sup>0</sup>
</div>
</div></td></tr>
</table></td>
<td class="daughter daughter-right"><table class="constituent lex" data-token="mean" data-from="19" data-to="23">
<tr><td class="token">mean</td></tr>
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
<td class="daughter daughter-right"><table class="constituent lex" data-token="?" data-from="23" data-to="24">
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

<h4>Vocatives</h4>

<p>In case of vocatives following a comma following some utterance, we give a
special category to the comma to combine the utterance with the vocative, as in
the following example:</p>

<div class=der>
	<div class=lexlist>
		<table class=lex>
			<tr>
				<td class="token">Vaarwel</td>
			</tr>
			<tr>
				<td class="cat">S[intj]</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">,</td>
			</tr>
			<tr>
				<td class="cat">(S[intj]\S[intj])/NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">Sayoko</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
	</div>
</div>

<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

$title = 'CCGWeb - Manual';
require('inc/head.inc.php');
?>

<div class=container>

<h2>Manual</h2>

<p>CCGweb aims to build a multilingual corpus of CCG annotations for evaluating
derivation projection algorithms and cross-lingually trained parsers.</p>

<p>We opt here for a flavor of CCG closely following CCGrebank. The reason for
this choice is that a large volume of training data in this format (for
English) is available. Having test data (in multiple languages) in a similar
format will enable a more direct comparison.</p>

<p>Of course, the annotation format for CCGrebank has only been specified for
English. It is not always obvious how to apply it to other languages. This
continually growing document gives guidelines, alphabetically sorted by the
linguistic phenomenon in question.</p>

<h3>Argument Order</h3>

<p>One verb category in English may correspond to two or more different verb
categories in German and Dutch, depending on clause type (main vs.
subordinate), and also depending on other aspects of argument order – for
example, in main clauses, it is often the subject that appears before the verb,
but not always.</p>

<p>We do not aim to capture multiple argument orders with the same category,
nor do we aim to make verbs combine with their arguments in any particular
order (e.g., by obliqueness).  We just write verb categories so that they first
combine with their right-hand arguments (from left to right) and then with
their left-hand arguments (from right to left):</p>

<div class=der>
	<div class=lexlist>
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
				<td class="token">ich</td>
			</tr>
			<tr>
				<td class="cat">NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">den</td>
			</tr>
			<tr>
				<td class="cat">NP/N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">Hund</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">sehe</td>
			</tr>
			<tr>
				<td class="cat">(S[dcl]\NP)\NP</td>
			</tr>
		</table>
	</div>
</div>

<div class=der>
	<div class=lexlist>
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
				<td class="token">den</td>
			</tr>
			<tr>
				<td class="cat">NP/N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">Hund</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">ich</td>
			</tr>
			<tr>
				<td class="cat">NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">sehe</td>
			</tr>
			<tr>
				<td class="cat">(S[dcl]\NP)\NP</td>
			</tr>
		</table>
	</div>
</div>

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
				<td class="token">sehe</td>
			</tr>
			<tr>
				<td class="cat">(S[dcl]\NP)/NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">den</td>
			</tr>
			<tr>
				<td class="cat">NP/N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">Hund</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
	</div>
</div>

<div class=der>
	<div class=lexlist>
		<table class=lex>
			<tr>
				<td class="token">Den</td>
			</tr>
			<tr>
				<td class="cat">NP/N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">Hund</td>
			</tr>
			<tr>
				<td class="cat">N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">sehe</td>
			</tr>
			<tr>
				<td class="cat">(S[dcl]\NP)/NP</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">ich</td>
			</tr>
			<tr>
				<td class="cat">NP</td>
			</tr>
		</table>
	</div>
</div>

<h3>Clause Types</h3>

<p>CCGrebank distinguishes different subtypes of the basic S category with
features: <code>[ng]</code> for present participle, <code>[pt]</code> for past
participle, <code>[dcl]</code> for indicative, <code>[b]</code> for infinitive
and imperative, <code>[to]</code> for <i>to</i>-infinitive, <code>[q]</code>
for yes/no questions, <code>[wq]</code> for <i>wh</i>-questions,
<code>[em]</code> for embedded clauses and <code>[intj]</code> for
interjections.</p>

<p>Although this feature set is designed for English and additional
distinctions would make sense for other languages (for example, main vs.
subordinate clause for German and Dutch), the features can in most cases be
applied to our target languages, and we stick with the existing feature set for
now.</p>

<p>VP and S modifiers are underspecified for the clause type they modify, using
just plain <code>S</code> categories.</p>

<h3>Conditional Clauses</h3>

<p>Conditional clauses are attached at the VP level. For example:</p>

<div class=der>
	<table class="constituent binaryrule">
		<tr class="daughters">
			<td class="daughter daughter-left">
				<div class=lexlist>
					<table class=lex>
						<tr>
							<td class="token">What</td>
						</tr>
						<tr>
							<td class="cat">S[wq]/(S[q]/NP)</td>
						</tr>
					</table>
					<table class=lex>
						<tr>
							<td class="token">would</td>
						</tr>
						<tr>
							<td class="cat">(S[q]/(S[b]\NP))/NP</td>
						</tr>
					</table>
					<table class=lex>
						<tr>
							<td class="token">you</td>
						</tr>
						<tr>
							<td class="cat">NP</td>
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
									<td class="token">say</td>
								</tr>
								<tr>
									<td class="cat">(S[b]\NP)/NP</td>
								</tr>
							</table>
						</td>
						<td class="daughter daughter-right">
							<table class="constituent unaryrule">
								<tr class="daughters">
									<td class="daughter daughter-only">
										<div class=lexlist>
											<table class=lex>
												<tr>
													<td class="token">if</td>
												</tr>
												<tr>
													<td class="cat">((S\NP)\(S\NP))/S[dcl]</td>
												</tr>
											</table>
											<table class=lex>
												<tr>
													<td class="token">you</td>
												</tr>
												<tr>
													<td class="cat">NP</td>
												</tr>
											</table>
											<table class=lex>
												<tr>
													<td class="token">were</td>
												</tr>
												<tr>
													<td class="cat">(S[dcl]\NP)/PP</td>
												</tr>
											</table>
											<table class=lex>
												<tr>
													<td class="token">in</td>
												</tr>
												<tr>
													<td class="cat">PP/NP</td>
												</tr>
											</table>
											<table class=lex>
												<tr>
													<td class="token">my</td>
												</tr>
												<tr>
													<td class="cat">NP/(N/PP)</td>
												</tr>
											</table>
											<table class=lex>
												<tr>
													<td class="token">place</td>
												</tr>
												<tr>
													<td class="cat">N/PP</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2" class="rulecat">
										<div class="rulecat">
											<div class="cat">(S\NP)\(S\NP)</div>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="rulecat">
							<div class="rulecat">
								<div class="cat">S[b]\NP</div>
								<div class="rule" title="Backward application">&lt;<sup>0</sup></div>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<h3>Contractions of Preposition and Determiner</h3>

<p>Contractions of preposition and determiner such as German <i>zum</i> and
Italian <i>al</i> have category <code>PP/N</code> (if they head a PP argument,
replace PP as appropriate if they head modifiers).</p>

<h3>Demonyms: Adjectives vs. Nouns</h3>

<p>Our languages have different preferences for demonyms. For example,
<i>French</i> and <i>francese</i> are adjectives whereas <i>Französin</i> and
<i>Franse</i> are nouns and should be annotated accordingly.</p>

<h3><i>er</i></h3>

<p>The Dutch particle <i>er</i> is analyzed as a <code>PP</code>.</p>

<h3>Possessive Determiners vs. Adjectives</h3>

<p>Unlike in English, German and Dutch, in Italian, possessive determiners can
also function as attributive adjectives, following a separate determiner.
In this case, they have category <code>N/(N/PP)</code> rather than
<code>NP/(N/PP)</code>. For example:</p>

<div class=der>
	<div class=lexlist>
		<table class=lex>
			<tr>
				<td class="token">il</td>
			</tr>
			<tr>
				<td class="cat">NP/N</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">mio</td>
			</tr>
			<tr>
				<td class="cat">N/(N/PP)</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">libro</td>
			</tr>
			<tr>
				<td class="cat">N/PP</td>
			</tr>
		</table>
	</div>
</div>

<div class=der>
	<div class=lexlist>
		<table class=lex>
			<tr>
				<td class="token">mio</td>
			</tr>
			<tr>
				<td class="cat">NP/(N/PP)</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">fratello</td>
			</tr>
			<tr>
				<td class="cat">N/PP</td>
			</tr>
		</table>
	</div>
</div>

<h3>Pro-drop</h3>

<p>Subject pronouns are frequently dropped in Italian. We then give the verb a
category with no subject argument, as this is what derivation projection should
aim for to achieve semantic equivalence. For example:</p>

<div class=der>
	<div class=lexlist>
		<table class=lex>
			<tr>
				<td class="token">Voglio</td>
			</tr>
			<tr>
				<td class="cat">S[dcl]/(S[b]\NP)</td>
			</tr>
		</table>
		<table class=lex>
			<tr>
				<td class="token">dormire</td>
			</tr>
			<tr>
				<td class="cat">S[b]\NP</td>
			</tr>
		</table>
	</div>
</div>

<h3>Punctuation</h3>

<p>Sentence-final punctuation attaches at the top level.</p>

<h3><i>too X for Y</i></h3>

<p>In this construction, <i>for Y</i> is analyzed as a PP argument of
<i>too</i>, not of the adjective <i>X</i>. Accordingly with <i>zu X für Y</i>,
<i>te X voor Y</i> and <i>troppo X per Y</i>.</p>

<h3>Vocatives</h3>

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
				<td class="cat">(S\S)/NP</td>
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

</div>

<?php
require('inc/foot.inc.php');
?>

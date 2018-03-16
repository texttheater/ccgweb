<h3>Punctuation</h3>

<p>In a slight departure from CCGrebank, we do not use the special punctuation
categories (<code>,</code>, <code>.</code>, <code>:</code>, <code>;</code>,
<code>LRB</code>, <code>RRB</code>, <code>LQU</code>, <code>RQU</code>) or the
corresponding punctuation rules. Instead, we give punctuation symbols real CCG
modifier categories that, unlike real modifiers, are specified for
→ <a href=<?= url('manual.php', ['section' => 'clause-types']) ?>>clause type</a>. We combine them with constituents via application.</p>

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

<p>Commas separating subordinate clauses from main clauses attach to the
subordinate clause. For example:</p>

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

<p>With quoted material, the surrounding quotation marks attach in a
right-branching fashion. If there is a choice between attaching at the
<code>N</code> vs. <code>NP</code> level, attach at the <code>NP</code> level.
For example:</p>

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

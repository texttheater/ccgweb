<h3>Coordination</h3>

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
											<div class="cat">S[dcl]</div>
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
								<div class="cat">S[dcl]</div>
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

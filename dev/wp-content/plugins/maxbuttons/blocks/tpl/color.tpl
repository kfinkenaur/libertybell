		{if:label} 	<label class='color'>%%label%%</label> {/if:label} 

	<div class="input color %%name%%">

		<span class="colorpicker-box {if:inputclass} %%inputclass%% {/if:inputclass} " id="%%id%%_box">
						<span></span>
		</span>
		<input style="display: none;" type="text" id="%%id%%" name="%%name%%" 
		value="%%value%%" />
	</div>

<form name="homesearch" action="/homes/" method="get">
	<input type="hidden" name="s" value="" />
	<div class="form-row">
		<div class="form-field styled-select">
			<label>Min Price</label>
			<select name="price-min">
				<option disabled="disabled" selected="selected"></option>
				<option value="0">Any</option>
				<?php /*
				<option <?php echo $_SESSION['price-min'] == '170000' ? 'selected="selected"' : ''; ?> value="170000">High $100,000s</option>
				<option <?php echo $_SESSION['price-min'] == '200000' ? 'selected="selected"' : ''; ?> value="200000">Low $200,000s</option>
				<option <?php echo $_SESSION['price-min'] == '235000' ? 'selected="selected"' : ''; ?> value="235000">Mid $200,000s</option>
				<option <?php echo $_SESSION['price-min'] == '270000' ? 'selected="selected"' : ''; ?> value="270000">High $200,000s</option>
				*/ ?>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '300000' ? 'selected="selected"' : ''; ?> value="300000">Low $300,000s</option>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '335000' ? 'selected="selected"' : ''; ?> value="335000">Mid $300,000s</option>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '370000' ? 'selected="selected"' : ''; ?> value="370000">High $300,000s</option>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '400000' ? 'selected="selected"' : ''; ?> value="400000">Low $400,000s</option>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '435000' ? 'selected="selected"' : ''; ?> value="435000">Mid $400,000s</option>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '470000' ? 'selected="selected"' : ''; ?> value="470000">High $400,000s</option>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '500000' ? 'selected="selected"' : ''; ?> value="500000">Low $500,000s</option>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '535000' ? 'selected="selected"' : ''; ?> value="535000">Mid $500,000s</option>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '570000' ? 'selected="selected"' : ''; ?> value="570000">High $500,000s</option>
				<option <?php echo isset($_SESSION['price-min']) && $_SESSION['price-min'] == '600000' ? 'selected="selected"' : ''; ?> value="600000">$600,000+</option>
			</select>
		</div>
		
		<div class="form-field styled-select">
			<label>Max Price</label>
			<select name="price-max">
				<option disabled="disabled" selected="selected"></option>
				<option value="600000">Any</option>
				<?php /*
				<option <?php echo $_SESSION['price-max'] == '199999' ? 'selected="selected"' : ''; ?> value="199999">High $100,000s</option>
				<option <?php echo $_SESSION['price-max'] == '235000' ? 'selected="selected"' : ''; ?> value="235000">Low $200,000s</option>
				<option <?php echo $_SESSION['price-max'] == '270000' ? 'selected="selected"' : ''; ?> value="270000">Mid $200,000s</option>
				<option <?php echo $_SESSION['price-max'] == '299999' ? 'selected="selected"' : ''; ?> value="299999">High $200,000s</option>
				*/ ?>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '335000' ? 'selected="selected"' : ''; ?> value="335000">Low $300,000s</option>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '370000' ? 'selected="selected"' : ''; ?> value="370000">Mid $300,000s</option>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '399999' ? 'selected="selected"' : ''; ?> value="399999">High $300,000s</option>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '435000' ? 'selected="selected"' : ''; ?> value="435000">Low $400,000s</option>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '470000' ? 'selected="selected"' : ''; ?> value="470000">Mid $400,000s</option>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '499999' ? 'selected="selected"' : ''; ?> value="499999">High $400,000s</option>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '535000' ? 'selected="selected"' : ''; ?> value="535000">Low $500,000s</option>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '570000' ? 'selected="selected"' : ''; ?> value="570000">Mid $500,000s</option>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '599999' ? 'selected="selected"' : ''; ?> value="599999">High $500,000s</option>
				<option <?php echo isset($_SESSION['price-max']) && $_SESSION['price-max'] == '999999' ? 'selected="selected"' : ''; ?> value="999999">$600,000+</option>
			</select>
		</div>
		
		<div class="form-field styled-select short">
			<label>Beds</label>
			<select name="beds-min">
				<option disabled="disabled" selected="selected"></option>
				<option value="0">Any</option>
				<option <?php echo isset($_SESSION['beds-min']) && $_SESSION['beds-min'] == '2' ? 'selected="selected"' : ''; ?> value="2">2+</option>
				<option <?php echo isset($_SESSION['beds-min']) && $_SESSION['beds-min'] == '3' ? 'selected="selected"' : ''; ?> value="3">3+</option>
				<option <?php echo isset($_SESSION['beds-min']) && $_SESSION['beds-min'] == '4' ? 'selected="selected"' : ''; ?> value="4">4+</option>
				<option <?php echo isset($_SESSION['beds-min']) && $_SESSION['beds-min'] == '5' ? 'selected="selected"' : ''; ?> value="5">5+</option>
				<option <?php echo isset($_SESSION['beds-min']) && $_SESSION['beds-min'] == '6' ? 'selected="selected"' : ''; ?> value="6">6+</option>
			</select>
		</div>

		<div class="form-field styled-select short">
			<label>Baths</label>
			<select name="baths-min">
				<option disabled="disabled" selected="selected"></option>
				<option value="0">Any</option>
				<option <?php echo isset($_SESSION['baths-min']) && $_SESSION['baths-min'] == '2' ? 'selected="selected"' : ''; ?> value="2">2+</option>
				<option <?php echo isset($_SESSION['baths-min']) && $_SESSION['baths-min'] == '2.5' ? 'selected="selected"' : ''; ?> value="2.5">2.5+</option>
				<option <?php echo isset($_SESSION['baths-min']) && $_SESSION['baths-min'] == '3' ? 'selected="selected"' : ''; ?> value="3">3+</option>
				<option <?php echo isset($_SESSION['baths-min']) && $_SESSION['baths-min'] == '3.5' ? 'selected="selected"' : ''; ?> value="3.5">3.5+</option>
				<option <?php echo isset($_SESSION['baths-min']) && $_SESSION['baths-min'] == '4' ? 'selected="selected"' : ''; ?> value="4">4+</option>
				<option <?php echo isset($_SESSION['baths-min']) && $_SESSION['baths-min'] == '4.5' ? 'selected="selected"' : ''; ?> value="4.5">4.5+</option>
				<option <?php echo isset($_SESSION['baths-min']) && $_SESSION['baths-min'] == '5' ? 'selected="selected"' : ''; ?> value="5">5+</option>
				<option <?php echo isset($_SESSION['baths-min']) && $_SESSION['baths-min'] == '5.5' ? 'selected="selected"' : ''; ?> value="5.5">5.5+</option>
			</select>
		</div>

		<div class="form-field styled-select">
			<label>Square Feet</label>
			<select name="sqft-min">
				<option disabled="disabled" selected="selected"></option>
				<option value="0">Any</option>
				<?php /*
				<option <?php echo $_SESSION['sqft-min'] == '1000' ? 'selected="selected"' : ''; ?> value="1000">1000+ Sqft</option>
				*/ ?>
				<option <?php echo isset($_SESSION['sqft-min']) && $_SESSION['sqft-min'] == '1500' ? 'selected="selected"' : ''; ?> value="1500">1500+ Sqft</option>
				<option <?php echo isset($_SESSION['sqft-min']) && $_SESSION['sqft-min'] == '2000' ? 'selected="selected"' : ''; ?> value="2000">2000+ Sqft</option>
				<option <?php echo isset($_SESSION['sqft-min']) && $_SESSION['sqft-min'] == '2500' ? 'selected="selected"' : ''; ?> value="2500">2500+ Sqft</option>
				<option <?php echo isset($_SESSION['sqft-min']) && $_SESSION['sqft-min'] == '3000' ? 'selected="selected"' : ''; ?> value="3000">3000+ Sqft</option>
				<option <?php echo isset($_SESSION['sqft-min']) && $_SESSION['sqft-min'] == '3500' ? 'selected="selected"' : ''; ?> value="3500">3500+ Sqft</option>
				<option <?php echo isset($_SESSION['sqft-min']) && $_SESSION['sqft-min'] == '4000' ? 'selected="selected"' : ''; ?> value="4000">4000+ Sqft</option>
			</select>
		</div>

		<div class="form-field submit">
			<input type="submit" id="homesearch-submit" class="btn" value="Search" />
		</div>
	</div>
</form>

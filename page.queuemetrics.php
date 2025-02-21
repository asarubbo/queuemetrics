<?php 
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

$settings = queuemetrics_get_details();

foreach ($settings as $key => $val) {
	// Ensure the key exists and is a valid string
	$keyword = is_string($val['keyword']) ? $val['keyword'] : 'unknown_key';

	// Ensure value is not an array
	$value = isset($_REQUEST[$keyword]) ? $_REQUEST[$keyword] : $val['value'];

	if (is_array($value)) {
		$value = json_encode($value); // Convert array to JSON string
	}

	$var[$keyword] = $value;
	${$keyword} = $value; // Dynamically create a variable
}

$checked = (isset($ivr_logging) && $ivr_logging == 'true')?'CHECKED':'';

echo '<h2 id="title">QueueMetrics</h2>';
echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">';
echo '<input type="hidden" name="action" value="save">'; 
echo '<br /><br />';

$table = new CI_Table();

$table->add_row( _('Settings'));
$table->add_row('<hr class="qmhr">');
$table->add_row('<a href="javascript:void(null)" class="info">Log IVR Selections <span style="left: -18px; display: none; ">' . _('When checked, IVR selections will be reported by QueueMetrics') . '</span></a>', '<input type="checkbox" name="ivr_logging" value="true" ' . $checked . '>');	
$table->add_row('');
$table->add_row('');
$table->add_row('<input type="submit" name="' . _("Submit Changes"). '">');

echo $table->generate();	

echo '</form><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';

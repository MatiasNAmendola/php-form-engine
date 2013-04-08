<?php
include '../lib/autoloader.php';

foreach (glob('../lib/FormEngine/Field/*.php') as $file)
{
	$types[] = strtolower(basename($file, '.php'));
}

foreach (range(1, 5) as $i)
{
	$options['value'.$i] = 'Option '.$i;
}

foreach ($types as $type)
{
	$fields[] = array(
		'label' => 'Please enter a '.$type.': ',
		'name' => $type.'_name',
		'type' => $type,
		'options' => $options
	);
}




$form = new \FormEngine\Form($fields);
ob_start();
echo $form->open(array(
	'action' => 'http://localhost/php-form-engine/test/?_='.md5(microtime()),
	'method' => 'post',
	'accept-charset' => 'utf-8',
));
foreach ($form->fields() as $field)
{
	echo '<div>'."\n";
	echo $field->label()."\n";
	echo $field->input()."\n";
	echo '</div>'."\n";
}

echo '<button type="submit">Submit</button>';

echo $form->close();
$output = ob_get_clean();

echo $output;

echo '<hr>';

echo '<pre>'.htmlspecialchars($output).'</pre>';

// $tidy = tidy_parse_string($output, array(
	// 'indent' => TRUE,
	// 'output-xhtml' => false,
	// 'wrap' => 100
// ), 'UTF8');
// $tidy->cleanRepair();
// echo '<pre>'.htmlspecialchars($tidy).'</pre>';


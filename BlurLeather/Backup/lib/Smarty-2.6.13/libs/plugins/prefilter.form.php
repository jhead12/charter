<?php

/*
 * prefilter.form.php
 *
 * @(#) $Header: /home/mlemos/cvsroot/forms/plugins/prefilter.form.php,v 1.3 2004/04/05 05:13:51 mlemos Exp $
 *
 */

function smarty_prefilter_form($tpl_source, &$smarty)
{
	$search=array(
		'/{input\s+name=("[^"]+"|\'[^\']+\'|\S+)}/i',
		'/{hiddeninput\s+name=("[^"]+"|\'[^\']+\'|\S+)}/i',
		'/{label\s+for=("[^"]+"|\'[^\']+\'|\S+)}/i',
		'/({include[^}]*})/i'
	);
	$replace=array(
		'{/capture}{insert name="formaddinputpart" input=\\1 data=$smarty.capture.formdata}{capture name="formdata"}',
		'{/capture}{insert name="formaddinputhiddenpart" input=\\1 data=$smarty.capture.formdata}{capture name="formdata"}',
		'{/capture}{insert name="formaddlabelpart" for=\\1 data=$smarty.capture.formdata}{capture name="formdata"}',
		'{/capture}{insert name="formadddatapart" data=$smarty.capture.formdata}\\1{capture name="formdata"}'
	);
	return('{capture name="formdata"}'.preg_replace($search,$replace,$tpl_source).'{/capture}{insert name="formadddatapart" data=$smarty.capture.formdata}');
}

?>
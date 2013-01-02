<?php
require_once('../qcubed.inc.php');

if (!isset($this)) {

	// Define the Qform with all our Qcontrols
	class ExampleSingleForm extends QForm {

		// Local declarations of our Qcontrols
		protected $lblMessage;
		protected $btnButton;

		// Initialize our Controls during the Form Creation process
		protected function Form_Create() {
			// Define the Label
			$this->lblMessage = new QLabel($this);
			$this->lblMessage->Text = 'Click the button to change my message.';

			// Definte the Button
			$this->btnButton = new QButton($this);
			$this->btnButton->Text = 'Click Me!';

			// Add a Click event handler to the button -- the action to run is an AjaxAction.
			// The AjaxAction names a PHP method (which will be run asynchronously) called "btnButton_Click"
			$this->btnButton->AddAction(new QClickEvent(), new QAjaxAction('btnButton_Click'));
		}

		// The "btnButton_Click" Event handler
		protected function btnButton_Click($strFormId, $strControlId, $strParameter) {
			$this->lblMessage->Text = 'Hello, world!';
		}

	}

	// Run the Form we have defined
	// Note that we explicitly specify the PHP variable __FILE__ (e.g. THIS script)
	// as the template file to use, and that we call "return;" to ensure that the rest
	// of this script doesn't process on its initial run.  Instead, it will be processed
	// a second time by QCubed as the QForm is being rendered.
	ExampleSingleForm::Run('ExampleSingleForm', __FILE__);
	return;
}

// Specify the Template below
?>

<?php require('../includes/header.inc.php'); ?>
<?php $this->RenderBegin(); ?>

<div id="instructions">
	<h1>Hello World, Revisited... Again... Again</h1>

	<p>We use the AJAX-enabled "Hello World" example to explain how you can make single file <strong>QForm</strong> pages.
		Note that this approach is <em>not always recommended</em> -- keeping the display logic (.php) file separate
		from the presentation HTML template (.tpl.php) file helps to enforce the good design and separation of display
		logic from the presentation layer (e.g. keeping the V and C separate in MVC).</p>

	<p>However, there may be times when you want a simpler architecture of single-file forms, or you
		are making some very simple <strong>QForm</strong> pages and you do not want to deal with the overhead
		of the dual-file format.  This example shows how you can use built-in PHP functionality to code your
		<strong>QForm</strong> as a single .php file.</p>

	<p>Feel free to <strong>View Source</strong> (the button below) to see how this is done.</p>
</div>

<div class="demo-zone">
	<p><?php $this->lblMessage->Render(); ?></p>
	<p><?php $this->btnButton->Render(); ?></p>
</div>

<?php $this->RenderEnd(); ?>
<?php require('../includes/footer.inc.php'); ?>
		/**
		 * Create and setup QDateTimePicker <?= $strControlId ?>

		 * @param string $strControlId optional ControlId to use
		 * @return QDateTimePicker
		 */
		public function <?= $strControlId ?>_Create($strControlId = null) {
			$this-><?= $strControlId ?> = new QDateTimePicker($this->objParentObject, $strControlId);
			$this-><?= $strControlId ?>->Name = QApplication::Translate('<?= QCodeGen::MetaControlControlName($objColumn) ?>');
			$this-><?= $strControlId ?>->DateTime = $this-><?= $strObjectName ?>-><?= $objColumn->PropertyName ?>;
			$this-><?= $strControlId ?>->DateTimePickerType = QDateTimePickerType::<?php
	switch ($objColumn->DbType) {
		case QDatabaseFieldType::DateTime:
			print 'DateTime';
			break;
		case QDatabaseFieldType::Time:
			print 'Time';
			break;
		default:
			print 'Date';
			break;
	}
?>;
<?php if ($objColumn->NotNull) { ?>
			$this-><?= $strControlId ?>->Required = true;
<?php } ?>
			return $this-><?= $strControlId ?>;
		}

		/**
		 * Create and setup QLabel <?= $strLabelId ?>

		 * @param string $strControlId optional ControlId to use
		 * @param string $strDateTimeFormat optional DateTimeFormat to use
		 * @return QLabel
		 */
		public function <?= $strLabelId ?>_Create($strControlId = null, $strDateTimeFormat = null) {
			$this-><?= $strLabelId ?> = new QLabel($this->objParentObject, $strControlId);
			$this-><?= $strLabelId ?>->Name = QApplication::Translate('<?= QCodeGen::MetaControlControlName($objColumn) ?>');
			$this->str<?= $objColumn->PropertyName ?>DateTimeFormat = $strDateTimeFormat;
			$this-><?= $strLabelId ?>->Text = sprintf($this-><?= $strObjectName ?>-><?= $objColumn->PropertyName ?>) ? $this-><?= $strObjectName ?>-><?= $objColumn->PropertyName ?>->qFormat($this->str<?= $objColumn->PropertyName ?>DateTimeFormat) : null;
<?php if ($objColumn->NotNull) { ?>
			$this-><?= $strLabelId ?>->Required = true;
<?php } ?>
			return $this-><?= $strLabelId ?>;
		}

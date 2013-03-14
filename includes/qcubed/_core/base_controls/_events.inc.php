<?php
/**
 * Classes in this file represent various "events" for QCubed. 
 * Programmer can "hook" into these events and write custom handlers.
 * Event-driven programming is explained in detail here: http://en.wikipedia.org/wiki/Event-driven_programming
 *
 * @package Events
 */

	/**
	 * Base class of QEvents.
	 * Events are used in conjunction with actions to respond to user actions, like clicking, typing, etc., 
	 * or even programmable timer events.
	 * @property-read string $EventName the javascript event name that will be fired
	 * @property-read string $Condition a javascript condition that is tested before the event is sent
	 * @property-read integer $Delay ms delay before action is fired
	 * @property-read string $JsReturnParam the javascript used to create the strParameter that gets sent to the event handler registered with the event.
	 * @property-read string $Selector a jquery selector, causes the event to apply to child items matching the selector, and then get sent up the chain to this object
	 * 
	 *
	 */
	abstract class QEvent extends QBaseClass {
		protected $strCondition = null;
		protected $intDelay = 0;
		protected $strSelector = null;

		/**
		 * Create an event.
		 * @param integer $intDelay ms delay to wait before action is fired
		 * @param string $strCondition javascript condition to check before firing the action
		 * @param string $strSelector jquery selector to cause event to be attached to child items instead of this item
		 * @throws QCallerException
		 */
		public function __construct($intDelay = 0, $strCondition = null, $strSelector = null) {
			try {
				if ($intDelay)
					$this->intDelay = QType::Cast($intDelay, QType::Integer);
				if ($strCondition) {
					if ($this->strCondition)
						$this->strCondition = sprintf('(%s) && (%s)', $this->strCondition, $strCondition);
					else
						$this->strCondition = QType::Cast($strCondition, QType::String);
				}
				if ($strSelector) {
					$this->strSelector = $strSelector;
				}
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		public function __get($strName) {
			switch ($strName) {
				case 'EventName':
					$strEvent = constant(get_class($this).'::EventName');
					if ($this->strSelector) {
						$strEvent .= '","' . addslashes($this->strSelector);
					}
					return $strEvent;
				case 'Condition':
					return $this->strCondition;
				case 'Delay':
					return $this->intDelay;
				case 'JsReturnParam':
					$strConst = get_class($this).'::JsReturnParam';
					return defined($strConst) ? constant($strConst) : '';
				case 'Selector':
					return $this->strSelector;
					
				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
	}

	/**
	 * Blur event: keyboard focus moving away from the control.
	 */
	class QBlurEvent extends QEvent {
		const EventName = 'blur';
	}

	/**
	 * Be careful with change events for listboxes - 
	 * they don't fire when the user picks a value on many browsers!
	 */
	class QChangeEvent extends QEvent {
		const EventName = 'change';
	}

	class QClickEvent extends QEvent {
		const EventName = 'click';
	}

	class QDoubleClickEvent extends QEvent {
		const EventName = 'dblclick';
	}

	class QDragDropEvent extends QEvent {
		const EventName = 'drop';
	}

	/**
	 * Focus event: keyboard focus entering the control.
	 */
	class QFocusEvent extends QEvent {
		const EventName = 'focus';
	}
	
	/* added for V2 / jQuery support */
	class QFocusInEvent extends QEvent {
		const EventName = 'focusin';
	}
	
	/* added for V2 / jQuery support */
	class QFocusOutEvent extends QEvent {
		const EventName = 'focusout';
	}
	
	class QKeyDownEvent extends QEvent {
		const EventName = 'keydown';
	}

	class QKeyPressEvent extends QEvent {
		const EventName = 'keypress';
	}

	class QKeyUpEvent extends QEvent {
		const EventName = 'keyup';
	}

	class QMouseDownEvent extends QEvent {
		const EventName = 'mousedown';
	}
	
	class QMouseEnterEvent extends QEvent {
		const EventName = 'mouseenter';
	}

	class QMouseLeaveEvent extends QEvent {
		const EventName = 'mouseleave';
	}

	class QMouseMoveEvent extends QEvent {
		const EventName = 'mousemove';
	}

	class QMouseOutEvent extends QEvent {
		const EventName = 'mouseout';
	}

	class QMouseOverEvent extends QEvent {
		const EventName = 'mouseover';
	}

	class QMouseUpEvent extends QEvent {
		const EventName = 'mouseup';
	}

	class QMoveEvent extends QEvent {
		const EventName = 'onqcodomove';
	}

	class QResizeEvent extends QEvent {
		const EventName = 'onqcodoresize';
	}

	class QSelectEvent extends QEvent {
		const EventName = 'select';
	}

	class QEnterKeyEvent extends QKeyDownEvent {
		protected $strCondition = 'event.keyCode == 13';
	}
	
	class QEscapeKeyEvent extends QKeyDownEvent {
		protected $strCondition = 'event.keyCode == 27';
	}
	
	class QUpArrowKeyEvent extends QKeyDownEvent {
		protected $strCondition = 'event.keyCode == 38';
	}
	
	class QDownArrowKeyEvent extends QKeyDownEvent {
		protected $strCondition = 'event.keyCode == 40';
	}

	abstract class QJqUiEvent extends QEvent {
		// be sure to subclass your events from this class if they are JqUiEvents
	}

	abstract class QJqUiPropertyEvent extends QEvent {
		// be sure to subclass your events from this class if they are JqUiEvents
		protected $strJqProperty = '';

		public function __get($strName) {
			switch ($strName) {
				case 'JqProperty':
					return $this->strJqProperty;
				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
	}


	/**
	* 
	* a custom event with event delegation
	* With this event you can delegate any jquery event of child controls or any html element
	* to a parent. By using the selector you can limit the event sources this event
	* gets triggered from. You can use a css class (or any jquery selector) for
	* $strSelector. Example ( new QJsDelegateEvent("click",".remove",new QAjaxControlAction( ... )); )
	* 
	* This event can help you reduce the produced javascript to a minimum.
	* One positive side effect is that this event will also work for html child elements added
	* in the future (after the event was created).
	* 
	* @param $strEventName the name of the event i.e.: "click"
	* @param $strSelector i.e.: "#myselector" ==> results in: $('#myControl').on("myevent","#myselector",function()... 
	* 
	*/
	class QOnEvent extends QEvent{
		protected $strEventName;
		
		public function __construct($strEventName, $strSelector = null, $strCondition = null, $intDelay = 0) {
			$this->strEventName=$strEventName;
			if ($strSelector) {
				$strSelector = addslashes($strSelector);
				$this->strEventName .= '","'.$strSelector;
			}
			
			try {
				parent::__construct($intDelay,$strCondition, $strSelector);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}
		
		public function __get($strName) {
			switch ($strName) {
				case 'EventName':
					return $this->strEventName;
				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
		
	}

?>

<?php
/**
 * @author Aaron Scherer
 * @date   2/20/13
 */
namespace Uecode\Bundle\AmazonBundle\Component\SimpleWorkFlow\Event\Decider;

// Amazon Bundle's SWF Components
use \Uecode\Bundle\AmazonBundle\Component\SimpleWorkFlow\Event\AbstractEvent;
use \Uecode\Bundle\AmazonBundle\Component\SimpleWorkFlow\State\DeciderWorkerState;

class ActivityTaskScheduledEvent extends AbstractEvent
{

	public function __construct()
	{
		$this->setEventType( 'ActivityTaskScheduled' );

		$this->setEventLogic( function( $event, &$workflowState, &$timerOptions, &$activityOptions, &$continueAsNew, &$maxEventId ) {
			if ( $workflowState === DeciderWorkerState::NOTHING_OPEN ) {
				$workflowState = DeciderWorkerState::ACTIVITY_OPEN;
			} else if ( $workflowState === DeciderWorkerState::TIMER_OPEN ) {
				$workflowState = DeciderWorkerState::TIMER_AND_ACTIVITY_OPEN;
			}
		} );
	}
}
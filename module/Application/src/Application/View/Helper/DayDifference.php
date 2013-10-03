<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DayDifference extends AbstractHelper
{
    /**
     * @param \DateTime $date1
     * @param \DateTime $date2
     * @return string
     */
    public function __invoke(\DateTime $date1, \DateTime $date2 = null)
    {

        if ($date2 === null) {
            $date2 = new \DateTime();
        }

        $diff = $date1->diff($date2);

        if ($diff->y > 0) {
            return ($diff->y === 1) ? $diff->y . ' year ago' : $diff->m . ' years ago';
        }

        if ($diff->m > 0) {
            return ($diff->m === 1) ? $diff->m . ' month ago' : $diff->m . ' months ago';
        }

        if ($diff->d > 0) {
            return ($diff->d === 1) ? $diff->d . ' day ago' : $diff->h . ' days ago';
        }

        if($diff->h > 0) {
            return ($diff->h === 1) ? $diff->h . ' hour ago' : $diff->h . ' hours ago';
        }

        if($diff->i > 0) {
            return ($diff->i === 1) ? $diff->i . ' minute ago' : $diff->i . ' minutes ago';
        }

        if($diff->s > 0) {
            return ($diff->s === 1) ? $diff->s . ' second ago' : $diff->s . ' seconds ago';
        }

        return 'Right now';
    }
}
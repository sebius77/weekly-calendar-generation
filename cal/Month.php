<?php

namespace Sebius77\WeeklyCalendarGeneration\cal;

class Month {

    private $months = [
        'janvier',
        'février',
        'mars',
        'avril',
        'mai',
        'juin',
        'juillet',
        'août',
        'septembre',
        'octobre',
        'novembre',
        'décembre'
    ];
    private $days = [
      'Lundi',
      'Mardi',
      'Mercredi',
      'Jeudi',
      'Vendredi',
      'Samedi',
      'Dimanche'
    ];
    private $month;
    private $year;
    private $week;

    /**
     * Month constructor.
     * @throws
     * @param int $month Le mois compris entre 1 et 12
     * @param int $year L'année
     * @param int $week le numéro de semaine
     */
    public function __construct(int $month, int $year, int $week = null)
    {
        if ($month < 0 || $month > 12) {
            throw new \Exception(" Le mois $month n'est pas valide");
        }

        if ($year < 1970) {
            throw new \Exception("L'année est inférieur à 1970");
        }

        $this->setMonth($month);
        $this->setYear($year);

        if (!is_null($week)) {
            $this->setWeek($week);
        } else {
            $this->setWeek($this->getFirstWeek());
        }
    }

    /**
     * Retourne le mois en toute lettre
     * @return string
     */
    public function toString (): string {

        $months = $this->getMonths();

        return $months[$this->getMonth() - 1];
    }


    /**
     * Permet de récupérer le nombre de semaine sur 1 mois donné
     * @return int
     * @throws \Exception
     */
    public function getWeeks(): int
    {
        $start = $this->startMonthDay();
        $end = $this->endMonthDay();
        $cloneEnd = clone ($end);

        if (intval($end->format('W')) === 1) {
            $cloneEnd->modify('- 1 week');
            $weekEnd = intval($cloneEnd->format('W')) + 1;
        } else {
            $weekEnd = intval($end->format('W'));
        }

        $weeks = $weekEnd - intval($start->format('W')) + 1;

        if ($weeks < 0) {
            $weeks = intval($end->format('W')) + 1;
        }

        return $weeks;
    }

    /**
     * Donne le 1er jour du mois
     * @return \DateTime
     * @throws \Exception
     */
    public function startMonthDay() {
        return new \DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * Permet d'obtenir la date du premier jour de l'année
     * @return \DateTime
     * @throws \Exception
     */
    public function startYearDay() {
        return new \DateTime("{$this->year}-01-01");
    }

    /**
     * @param \DateTime $date
     * @return \DateTime
     */
    public function lastMonday(\DateTime $date)
    {
        if ($date->format('w') !== "1") {
            $date = clone($date)->modify('last monday');
        }

        return $date;
    }

    /**
     * Donne le dernier jour du mois
     * @return \DateTime
     * @throws \Exception
     */
    public function endMonthDay() {
        return (clone $this->startMonthDay())->modify(' +1 month -1 day');
    }

    /**
     * Permet de récupérer le numéro de première semaine d'un mois
     * @return int
     * @throws \Exception
     */
    public function getFirstWeek() : int
    {
        return $this->startMonthDay()->format('W');
    }

    public function generateWeekTab(\DateTime $monday, $user = null, $group = null, $room = null): array
    {
        $daysWeek = [
            'lundi' => [
                'day' => $monday->format('d'),
                'month' => $monday->format('m'),
                'data' => []
            ],
            'mardi' => [
                'day' => (clone $monday)->modify('+ 1 day')->format('d'),
                'month' => (clone $monday)->modify('+ 1 day')->format('m'),
                'data' => []
            ],
            'mercredi' => [
                'day' => (clone $monday)->modify('+ 2 day')->format('d'),
                'month' => (clone $monday)->modify('+ 2 day')->format('m'),
                'data' => []
            ],
            'jeudi' => [
                'day' => (clone $monday)->modify('+ 3 day')->format('d'),
                'month' => (clone $monday)->modify('+ 3 day')->format('m'),
                'data' => []
            ],
            'vendredi' => [
                'day' => (clone $monday)->modify('+ 4 day')->format('d'),
                'month' => (clone $monday)->modify('+ 4 day')->format('m'),
                'data' => []
            ],
            'samedi' => [
                'day' => (clone $monday)->modify('+ 5 day')->format('d'),
                'month' => (clone $monday)->modify('+ 5 day')->format('m'),
                'data' => []
            ],
        ];

        return $daysWeek;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function miniCal()
    {
        $string = '';
        $weeksNumber = $this->getWeeks();
        $days = $this->getDays();
        $firstWeek = $this->getFirstWeek();
        $monday = $this->lastMonday($this->startMonthDay());

        $string .='<tr><th>LUN</th><th>MAR</th><th>MER</th><th>JEU</th><th>VEN</th><th>SAM</th><th>DIM</th></tr>';

        $string .= '<tr id="week-' . $firstWeek . '">';
        for ($i = 0; $i < $weeksNumber; $i++) {
            foreach ($days as $k=>$day) {
                $date = (clone $monday)->modify("+" . ($k + $i * 7) . " day");

                if (intval($date->format('m')) !== $this->getMonth()) {
                    $string .= '<td style="color: gray;">' . $date->format('d') . '</td>';
                } else {
                    $string .= '<td id="day-' . $date->format('d') . '">' . $date->format('d') . '</td>';
                }

                if ($k === 6) {
                    $cloneDate = clone($date->modify('+ 1 week'));
                    $string .= '</tr><tr id="week-' . ($cloneDate->format('W')). '">';
                }
            }
        }
        return $string;
    }

    /**
     * @return array
     */
    public function getMonths(): array
    {
        return $this->months;
    }

    /**
     * @param array $months
     */
    public function setMonths(array $months): void
    {
        $this->months = $months;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month): void
    {
        $this->month = $month;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @param mixed $week
     */
    public function setWeek($week): void
    {
        $this->week = $week;
    }

    /**
     * @return array
     */
    public function getDays(): array
    {
        return $this->days;
    }
}

<?
/** 
 *  Test for Travel Department
 *  @package    Person
 *  @author     Raonny Lourenco <findme@raonny.com.br>
 *  Class that defines a type called Person, its parents and its brothers, a displays a genealogical tree based on the data given
 */
class Person {
    protected $name = "";
    protected $parents;
    protected $brothers;

    public function __construct($name) {
        $this->name     = $name;
        $this->parents  = array();
        $this->brothers = array();
    }

    function __toString() {
        return $this->name;
    }

    public function getName() {
        return $this->name;
    }

    public function getParents () {
        return $this->parents ?: array();
    }

    public function getBrothers () {
        return $this->brothers ?: array();
    }

    public function setParents(Person $child) {
        $child->parents[] = $this;
    }

    public function setBrothers(Person $child) {
        $child->brothers[] = $this;
    }

    public function addMom(Person $mom) {
        $mom->setParents($this);
    }

    public function addDad(Person $dad) {
        $dad->setParents($this);
    }

    public function addBrother(Person $brother) {
        $brother->setBrothers($this);
    }

}

////////////// USAGE EXAMPLE ////////////////
// Defining the family persons
$maurice    = new Person('Maurice');
$natalie    = new Person('Natalie');

$philips    = new Person('Philips');
$maria      = new Person('Maria');

$mauro      = new Person('Mauro');
$giulia     = new Person('Giulia');

$sara       = new Person('Sara');
$mike       = new Person('Mike');

$bobby      = new Person('Bobby');
$molly      = new Person('Molly');

// bottom of the testing tree
$debbie     = new Person('Debbie');
$judie      = new Person('Judie');
$jef        = new Person('Jef');

// adding the relations
$mauro->addMom($natalie);
$mauro->addDad($maurice);

$giulia->addMom($maria);
$giulia->addDad($philips);

$sara->addMom($giulia);
$sara->addDad($mauro);

$bobby->addMom($sara);
$bobby->addDad($mike);

$debbie->addMom($molly);
$debbie->addDad($bobby);

$debbie->addBrother($judie);
$debbie->addBrother($jef);

// recursive function to display the genealogical tree given a person in the bottom of the tree
function showTreeOf(Person $child, $level) {
    $level++;

    // opening the table to reading easier
    echo "<table border='1' align='center'><tr align='center' valign='bottom'><td>";

    // checking parents
    $parents = $child->getParents();
    if(count($parents) > 0) {

        echo "<table><tr valign='bottom'>";

            echo "<td>";
                showTreeOf($parents[0], $level);
            echo "</td>";

            echo "<td>";
                showTreeOf($parents[1], $level);
            echo "</td>";

        echo "</tr></table>";
    }

    // checking brothers
    $brothers = array();
    foreach($child->getBrothers() as $brother) {
        $brothers[] = $brother;
    }

    // displaying the names    
    echo $level. " - ";                                     // just to make easier to read
    echo $child->getName();                                 // name of the person
    if(count($brothers) > 0)                                // name of the brothers
        echo " (".implode(" , ", $brothers).")";

    
    // closing the tables
    echo "</td></tr></table>";

}

// showing the tree for Debbie
showTreeOf($debbie, 0);


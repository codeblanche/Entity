Tame your entities & Marshal them like a boss
=============================================

After much deliberation, a more apropriate name has been chosen for the previously (poorly) named DataObject.

But you still either love it, or you donut.


The time has come the marshal said...
=====================================

What is the purpose of the EntityMarshal? Well, I'm glad you asked. Primarily because I assumed you would and thus feel quite good about myself for this minor pre-emptive strike. Wow, Look at me being all smart.

Ok, well... this one time at band camp... It occurred to me that seperation between various architectural levels of software was 100% pure BUENO! (a.k.a 'good'). This however leaves one small caveat, namely. The data being passed back and forth between the layers, or on some occasions across applications is completely wild like a bull at a rodeo with a rope tied around it's coconuts and me sitting on top like a clown holding on for dear life trying to figure out what exactly is going on. // end of rant

Thus the EntityMarshal was born to save the day. It's purpose is to keep a good eye on your data entities (preferably defined) to make sure that the data you are transporting around your application is both clear and what you expect.


Yeah, but where does the meat go?
=================================

In short, it goes in you classes that extend the EntityMarshal and define the properties and types that your entities consist of.
	
For example:

    <?php

    use EntityMarshal\ObjectPropertyEntityMarshal as AbstractObjectPropertyEntityMarshal;

    class ObjectPropertyEntityMarshal extends AbstractObjectPropertyEntityMarshal
    {

        /**
         * @var boolean Alias of bool
         */
        public $testBoolean = true;

        /**
         * @var integer Alias of int
         */
        public $testInteger = 12345;

        /**
         * @var string
         */
        public $testString = "test string";

        /**
         * @var mixed
         */
        public $testMixed ;

        /**
         * @var array
         */
        public $testArray = array('1', '2', '3');

        /**
         * @var EntityMarshal\Sample\ObjectPropertyEntityMarshal[]
         */
        public $testTypedArray1;

        /**
         * @var array<EntityMarshal\Sample\ObjectPropertyEntityMarshal>
         */
        public $testTypedArray2;

        /**
         * @var integer[]
         */
        public $testTypedArray4;

    }

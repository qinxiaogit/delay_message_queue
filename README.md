# delay_message_queue

#### install method

composer require owlet/DelayMessage

####use  product

DelayMessage::Product($config)->push("hello world);

####use  comsume

DelayMessage::Comsume($config)->pop("hello world);

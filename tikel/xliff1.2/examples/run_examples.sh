#!/bin/bash

java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example01/target/okapi-example-01-0.22-SNAPSHOT.jar Main myFile.html -s pseudo myFile.out-pseudo.html
java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example01/target/okapi-example-01-0.22-SNAPSHOT.jar Main myFile.html -s upper myFile.out-upper.html
java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example01/target/okapi-example-01-0.22-SNAPSHOT.jar Main myFile.html -s pseudo -s upper myFile.out-both.html
java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example01/target/okapi-example-01-0.22-SNAPSHOT.jar Main myFile.odt -s pseudo
java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example01/target/okapi-example-01-0.22-SNAPSHOT.jar Main myFile.properties -s pseudo
java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example01/target/okapi-example-01-0.22-SNAPSHOT.jar Main myFile.xml -s pseudo

java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example02/target/okapi-example-02-0.22-SNAPSHOT.jar Main myFile.odt

java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example03/target/okapi-example-03-0.22-SNAPSHOT.jar Main

java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example04/target/okapi-example-04-0.22-SNAPSHOT.jar Main

java -cp .:../lib/okapi-lib-0.22-SNAPSHOT.jar:example05/target/okapi-example-05-0.22-SNAPSHOT.jar Main


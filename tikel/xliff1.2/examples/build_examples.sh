echo "Building example01"
rm example01/target/*
javac -d example01/target example01/src/main/java/*.java -cp ../lib/okapi-lib-0.22-SNAPSHOT.jar
jar cfm example01/target/okapi-example-01-0.22-SNAPSHOT.jar example01/META-INF/MANIFEST.MF -C example01/target .

echo "Building example02"
rm example02/target/*
javac -d example02/target example02/src/main/java/*.java -cp ../lib/okapi-lib-0.22-SNAPSHOT.jar
jar cfm example02/target/okapi-example-02-0.22-SNAPSHOT.jar example02/META-INF/MANIFEST.MF -C example02/target .

echo "Building example03"
rm example03/target/*
cp example03/src/main/resources/* example03/target
javac -d example03/target example03/src/main/java/*.java -cp ../lib/okapi-lib-0.22-SNAPSHOT.jar
jar cfm example03/target/okapi-example-03-0.22-SNAPSHOT.jar example03/META-INF/MANIFEST.MF -C example03/target .

echo "Building example04"
rm example04/target/*
javac -d example04/target example04/src/main/java/*.java -cp ../lib/okapi-lib-0.22-SNAPSHOT.jar
jar cfm example04/target/okapi-example-04-0.22-SNAPSHOT.jar example04/META-INF/MANIFEST.MF -C example04/target .

echo "Building example05"
rm example05/target/*
javac -d example05/target example05/src/main/java/*.java -cp ../lib/okapi-lib-0.22-SNAPSHOT.jar
jar cfm example05/target/okapi-example-05-0.22-SNAPSHOT.jar example05/META-INF/MANIFEST.MF -C example05/target .

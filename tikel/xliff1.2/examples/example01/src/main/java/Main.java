/*===========================================================================
  Copyright (C) 2009 by the Okapi Framework contributors
-----------------------------------------------------------------------------
  This library is free software; you can redistribute it and/or modify it 
  under the terms of the GNU Lesser General Public License as published by 
  the Free Software Foundation; either version 2.1 of the License, or (at 
  your option) any later version.

  This library is distributed in the hope that it will be useful, but 
  WITHOUT ANY WARRANTY; without even the implied warranty of 
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser 
  General Public License for more details.

  You should have received a copy of the GNU Lesser General Public License 
  along with this library; if not, write to the Free Software Foundation, 
  Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

  See also the full LGPL text here: http://www.gnu.org/copyleft/lesser.html
===========================================================================*/

import java.io.File;

import net.sf.okapi.common.MimeTypeMapper;
import net.sf.okapi.common.Util;
import net.sf.okapi.common.filters.FilterConfiguration;
import net.sf.okapi.common.filters.FilterConfigurationMapper;
import net.sf.okapi.common.filters.IFilterConfigurationMapper;
import net.sf.okapi.steps.common.RawDocumentToFilterEventsStep;
import net.sf.okapi.steps.common.FilterEventsWriterStep;
import net.sf.okapi.common.LocaleId;
import net.sf.okapi.common.pipelinedriver.BatchItemContext;
import net.sf.okapi.common.pipelinedriver.IPipelineDriver;
import net.sf.okapi.common.pipelinedriver.PipelineDriver;

public class Main {
	
	private static LocaleId srcLang = LocaleId.fromString("en");
	private static LocaleId trgLang = LocaleId.fromString("fr");
	private static String inputEncoding = "UTF-8";
	private static String outputEncoding = "UTF-8";
	private static String inputPath = null;
	private static String outputPath = null;
	private static String steps = "";
	private static IFilterConfigurationMapper fcMapper;
	
	public static void main (String[] args) {
		try {
			System.out.println("------------------------------------------------------------");
			if ( args.length == 0 ) {
				printUsage();
				return;
			}
			// Get the parameters
			for ( int i=0; i<args.length; i++ ) {
				if ( args[i].equals("-sl") ) srcLang = LocaleId.fromString(args[++i]);
				else if ( args[i].equals("-tl") ) trgLang = LocaleId.fromString(args[++i]);
				else if ( args[i].equals("-ie") ) inputEncoding = args[++i];
				else if ( args[i].equals("-oe") ) outputEncoding = args[++i];
				else if ( args[i].equals("-s") ) {
					if ( args[++i].equals("pseudo") ) steps += "p"; 
					else if ( args[i].equals("upper") ) steps += "u";
					else throw new RuntimeException("Unknown step.");
				}
				else if ( args[i].equals("-?") ) {
					printUsage();
					return;
				}
				else if ( inputPath == null ) inputPath = args[i];
				else outputPath = args[i];
			}
			
			if ( inputPath == null ) {
				throw new RuntimeException("No input file defined.");
			}
			if ( outputPath == null ) {
				outputPath = Util.getFilename(inputPath, false) + ".out" + Util.getExtension(inputPath); 
			}

			// Create the mapper
			fcMapper = new FilterConfigurationMapper();
			// Fill it with the default configurations of several filters
			fcMapper.addConfigurations("net.sf.okapi.filters.html.HtmlFilter");
			fcMapper.addConfigurations("net.sf.okapi.filters.openoffice.OpenOfficeFilter");
			fcMapper.addConfigurations("net.sf.okapi.filters.properties.PropertiesFilter");
			fcMapper.addConfigurations("net.sf.okapi.filters.xml.XMLFilter");
			
			// Detect the file to use
			String ext = Util.getExtension(inputPath);
			if ( Util.isEmpty(ext) ) throw new RuntimeException("No filter detected for the file extension.");
			ext = ext.substring(1); // No dot.
			String mimeType = MimeTypeMapper.getMimeType(ext);
			FilterConfiguration cfg = fcMapper.getDefaultConfiguration(mimeType);
			if ( cfg == null ) {
				throw new RuntimeException(String.format("No configuration defined for the MIME type '%s'.", mimeType));
			}
			
			// Display the parsed options
			System.out.println("            input file: " + inputPath);
			System.out.println("default input encoding: " + inputEncoding);
			System.out.println("           output file: " + outputPath);
			System.out.println("       output encoding: " + inputEncoding);
			System.out.println("       source language: " + srcLang);
			System.out.println("       target language: " + trgLang);
			System.out.println("    MIME type detected: " + mimeType);
			System.out.println("configuration detected: " + cfg.configId);
			
			// Process
			pipeline1(cfg);
		}
		catch ( Throwable e ) {
			e.printStackTrace();
		}
	}
	
	private static void printUsage () {
		System.out.println("Usage: [option(s)] inputFile[ outputFile]");
		System.out.println("where the options are:");
		System.out.println(" -sl <sourceLang>");
		System.out.println(" -tl <targetLang>");
		System.out.println(" -ie <inputEncoding>");
		System.out.println(" -oe <outputEncoding>");
		System.out.println(" -s pseudo|upper");
	}
	
	private static void pipeline1 (FilterConfiguration config) {
		// Create the driver
		IPipelineDriver driver = new PipelineDriver();
		
		// Add the filter step to the pipeline
		driver.addStep(new RawDocumentToFilterEventsStep());

		// Add one or more processing step(s)
		for ( int i=0; i<steps.length(); i++ ) {
			switch ( steps.charAt(i) ) {
			case 'p':
				driver.addStep(new PseudoTranslateStep());
				break;
			case 'u':
				driver.addStep(new UppercaseStep());
				break;
			}
		}

		// Add the writer step to the pipeline
		driver.addStep(new FilterEventsWriterStep());
		// Set the filter configuration mapper
		driver.setFilterConfigurationMapper(fcMapper);

		driver.addBatchItem(new BatchItemContext(
			(new File(inputPath)).toURI(), // URI of the input document
			inputEncoding, // Default encoding
			config.configId, // Filter configuration of the document
			(new File(outputPath)).toURI(), // Output
			outputEncoding, // Encoding for the output
			srcLang, // Source language
			trgLang)); // Target language
		
		driver.processBatch();
	}

}

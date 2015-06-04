# SOLAS-Extractor-and-Merger
SOLAS Extractor/Merger can be used for extraction of translatable content into valid XLIFF 1.2 files in cases the workflow initiator does not produce the XLIFF files on its own.

Any open service oriented architecture working upon the XLIFF exchange and messaging format is in need of an Extractor/Merger component that can produce workflow tokens with guaranteed standards compliance. The component provider conditionally calls OKAPI tikal or XLIFF 2.0 Toolikt based on the required XLIFF version. It provides a RESTFUL interface for other XLIFF and ITS aware agents involved in the roundtrip.

SOLAS Extractor/Merger supports open standards; it is ITS 2 aware by design via the XLIFF 1.2. and XLIFF 2.0 Mapping. It is a reference implementation of the XLIFF 2.0 and ITS 2.0 standards. This component serves as a RESTful wrapper around command line libraries and makes them uniformly accessible from the orchestration elements, and provides a messaging token for handling by other specialized agents taking part in the workflow. The same wrapping mechanism can be used for conditionally available and usable extraction/merging libraries, it is used to provide conditionally either XLIFF 1.2 or XLIFF 2.0 capability based on metadata or human user preference. However the development of the XLIFF 2.0 Toolkit has not yet been finalized, so this functionality is experimental and currently not capable of merging back.

**Coded by:**
* [Phillip O’Duffy](https://github.com/PhilipUL)

# License notice
This software is licensed under the terms of the GNU LESSER GENERAL PUBLIC LICENSE Version 3, 29 June 2007 For full terms see License.txt or http://www.gnu.org/licenses/lgpl-3.0.txt

# References

* http://www.w3.org/International/multilingualweb/lt/wiki/images/2/22/D3.1.2.pdf
* http://www.w3.org/International/multilingualweb/rome/posters/mlwlt_rome2013poster-07.pdf

## Acknowledgement
This research is supported by "FP7-ICT-2011-7 - Language technologies" Project "MultilingualWeb-LT (LT-Web) - Language Technology in the Web" (287815 - CSA).

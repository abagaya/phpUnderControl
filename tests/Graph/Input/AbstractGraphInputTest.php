<?php
/**
 * This file is part of phpUnderControl.
 * 
 * PHP Version 5.2.0
 *
 * Copyright (c) 2007-2011, Manuel Pichler <mapi@manuel-pichler.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * @category   QualityAssurance
 * @package    Graph
 * @subpackage Input
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2007-2011 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.phpundercontrol.org/
 */

require_once dirname( __FILE__ ) . '/../../AbstractTest.php';

/**
 * Abstract base class for input test cases.
 * 
 * @category   QualityAssurance
 * @package    Graph
 * @subpackage Input
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2007-2011 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: @package_version@
 * @link      http://www.phpundercontrol.org/
 */
abstract class phpucAbstractGraphInputTest extends phpucAbstractTest
{
    /**
     * Tests the result data for single log files.
     *
     * @return void
     * @group phpUnderControl
     * @group phpUnderControl::Graph
     * @group phpUnderControl::Graph::Input
     */
    public function testSingleLogResult()
    {
        $it = new phpucLogFileIterator( PHPUC_TEST_LOGS );
        foreach ( $it as $log )
        {
            $xpath = new DOMXPath( $log );
            
            $this->doTestSingleLog( $xpath );
        }
    }
    
    /**
     * Tests the summary result for the build breakdown.
     *
     * @return void
     * @group phpUnderControl
     * @group phpUnderControl::Graph
     * @group phpUnderControl::Graph::Input
     */
    public function testLogSumUp()
    {
        $input = $this->createInput();
        
        $summary = array();
        
        $it = new phpucLogFileIterator( PHPUC_TEST_LOGS );
        foreach ( $it as $log )
        {
            $xpath = new DOMXPath( $log );
            $input->processLog( $xpath );
            
            $summary = $this->doTestSumLog( $input, $xpath, $summary );
            
            $this->assertEquals( $summary, $input->data );
        }
    }
    
    /**
     * Create the context input object.
     *
     * @return phpucInputI
     */
    protected abstract function createInput();
    
    /**
     * Extracts the test data for a single log file and tests the result.
     *
     * @param DOMXPath $xpath The xpath instance for the log file.
     * 
     * @return void
     */
    protected abstract function doTestSingleLog( DOMXPath $xpath );
    
    /**
     * Tests the summary log result.
     *
     * @param phpucInputI $input    The context log input object.
     * @param DOMXPath    $xpath    The xpath instance for the log file.
     * @param array       $previous Results from previous calls.
     * 
     * @return array Merged $previous with actual results.
     */
    protected abstract function doTestSumLog( phpucInputI $input, DOMXPath $xpath, array $previous );
}

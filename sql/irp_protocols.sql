-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 19 Ago, 2017 at 05:09 PM
-- Versione MySQL: 5.0.45
-- Versione PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `remotesdb`
--

--
-- Dump dei dati per la tabella `irp_protocols`
--

INSERT INTO `irp_protocols` (`idprotocol`, `name`, `IRP`, `prt_url`, `phpadapter`, `notes`) VALUES
(2, 'NEC1_16', '{38.0k,562}<1,-1|1,-3>(16,-8,D:8,~D:8,F:8,~F:8,1,^110m,(16,-4,1,^110m)*)', './documents/protocols/NEC1_16.html', NULL, 'new IRP (2017 m.sillano)'),
(3, 'Fujitsu_Aircon', '{38.4k,413}<1,-1|1,-3>(8,-4,20:8,99:8,0:8,16:8,16:8,254:8,9:8,48:8,H:8,J:8, K:8, L:8, M:8,N:8,32:8,Z:8,1,-104.3m)+ {H=16*A + wOn, J=16*C + B, K=16*E:4 + D:4, L=tOff:8, M=tOff:3:8+fOff*8+16*tOn:4, N=tOn:7:4+128*fOn,Z=256-(H+J+K+L+M+N+80)%256, A=H:4:4,wOn=H:1,B=J:4,C=J:4:4,D=K:4,E=K:4:4,tOff=L+256*M:3, tOn=M:4:4+16*N:7,fOn=N:1:7,fOff=M:1:3}', './documents/protocols/FujitsuIR.pdf', 'Fujitsu_Aircon_adapter.php', 'only for testing dynamic keys and phpgui'),
(4, 'unknown01', NULL, NULL, NULL, 'test for learning RAW'),
(18, 'NEC1_48', '{38.0k,564}<1,-1|1,-3>(16,-8,D:8,S:8,F:8,~F:8,E:8,~E:8,1,^108m,(16,-4,1,^108m)*)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'This protocol signals repeats by the use of dittos.'),
(19, 'NEC2_48', '{38.0k,564}<1,-1|1,-3>(16,-8,D:8,S:8,F:8,~F:8,E:8,~E:8,1,^108m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'see NEC1_48'),
(20, 'AdNotam', '{35.7Khz,895,msb}<1,-1|-1,1>(1,-2,1,D:6,F:6,^114m)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Very similar to RC5, except AdNotam uses two start bits, and no toggle bit'),
(21, 'AirAsync', '{37.7Khz,840}<1|-1>(N=0,(1,B:8:N,-2,N=N+8)+)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'This protocol uses asynchronous data transmission that sends an 8-bit byte with 1 start bit, 8 data bits and 2 stop bits. The minimum signal is one byte. The protocol is reported as AirAsyncn-xx.yy. ... where n is the number of bytes and xx, yy, ... are the byte values in hexadecimal notation.'),
(22, 'Aiwa', '{38k,550}<1,-1|1,-3>(16,-8,D:8,S:5,~D:8,~S:5,F:8,~F:8,1,-42,(16,-8,1,-165)*', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(23, 'Akai', ' {38k,289}<1,-2.6|1,-6.3>(D:3,F:7,1,^25.3m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(24, 'Amino', '{36.0k,268,msb}<-1,1|1,-1>[T=1] [T=0] (7,-6,3,D:4,1:1,T:1,1:2,0:8,F:8,15:4,C:4,-79m)+ {C =(D:4+4*T+9+F:4+F:4:4+15)&15} ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Amino equipment use both 36 and 56KHz, but the duration of the half-bit is always 268. Zaptor is a closely related protocol which for which the half-bit duration is 330. '),
(25, 'Anthem', '{38.0k,605}<1,-1|1,-3>((8000u,-4000u,D:8,S:8,F:8,C:8,1,-25m)3, -75m)+ {C=~(D+S+F+255):8}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Anthem framing is very similar to NEC, and also uses 32 bits of data. However, the leadout is much shorter. The signal is sent at least 3 times. Anthem usually splits F into a 2 bit unit number, and a 6 bit function number.'),
(26, 'Apple', '{38.0k,564}<1,-1|1,-3>(16,-8,D:8,S:8,C:1,F:7,I:8,1,^108m,(16,-4,1,^108m)*) {C=~(#F+#PairID)&1)}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'C=1 if the number of 1 bits in the fields F and I is even. I is the remote ID.'),
(27, 'Archer', '{0k,12}<1,-3.3m|1,-4.7m>(F:5,1,-9.7m)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(28, 'Barco', '{0k,10}<1,-5|1,-15>(1,-25, D:5,F:6, 1,-25,1,120m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(29, 'Blaupunkt', '{30.3k,528}<-1,1|1,-1>(1,-5,1023:10,-39,1,-5,1:1,F:6,D:3,-230)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(30, 'Bose', '{38.0k,500,msb}<1,-1|1,-3>(2,-3,F:8,~F:8,1,-50m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(31, 'Bryston', '{38.0k,315} <1,-6|6,-1>(D:10,F:8, -18m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(32, 'CanalSat', '{55.5k,250,msb}<-1,1|1,-1>(T=0,(1,-1,D:7,S:6,T:1,0:1,F:7,-89m,T=1)+)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The repeat frames are not all identical. T toggles within a single signal, with T=0 for the start frame and T=1 for all repeats. DecodeIR v2.37 and later check T and will report in the Misc field if the start frame is missing. The official name for CanalSat is "ruwido r-step".'),
(33, 'CanalSatLD', ' {56k,320,msb}<-1,1|1,-1>(T=0,(1,-1,D:7,S:6,T:1,0:1,F:6,~F:1,-85m,T=1)+)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The official name for CanalSatLD is "ruwido r-step"'),
(34, 'Denon', '{38k,264}<1,-3|1,-7>(D:5,F:8,0:2,1,-165,D:5,~F:8,3:2,1,-165)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'A Denon signal is identical to Sharp, and has two halves, either one of which is enough to fully decode the information.'),
(35, 'Denon_K', '{37k,432}<1,-1,1,-3>(8,-4,84:8,50:8,0:4,D:4,S:4,F:12,((D*16)^S^(F*16)^(F:8:4)):8,1,-173)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Denon-K is the member of the Kaseikyo family with OEM_code1=84 and OEM_code2=50. Denon-K uses the same check byte rules as Panasonic protocol, but uses the data bits differently. The Panasonic Combo protocol in KM can be used with some difficulty to produce Denon-K signals. The Denon-K choice in RM uses the same protocol executor as Panasonic combo, but computes the hex commands based on Denon''s use of the Kaseikyo data bits.'),
(36, 'Dgtec', '{38k,560}<1,-1|1,-3>(16,-8,D:8,F:8,~F:8,1,^108m,(16,-4,1,^108m)+)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(37, 'DirecTV', '{38k,600,msb}<1,-1|1,-2|2,-1|2,-2>(5,(5,-2,D:4,F:8,C:4,1,-50)+) {C=7*(F:2:6)+5*(F:2:4)+3*(F:2:2)+(F:2)}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'There are six variants of the DirecTV protocol. The IRP notation above corresponds to the default Parm=3. The various Parm values correspond to three different frequencies (the 38k in the above) and two different lead-out times (the -50 in the above). The corresponding values are: Parm=0 : 40k, -15 Parm=1 : 40k, -50 Parm=2 : 38k, -15 Parm=3 : 38k, -50 Parm=4 : 57k, -15 Parm=5 : 57k, -50'),
(38, 'Dishplayer', '{38.4k,535,msb}<1,-5|1,-3>(1,-11,(F:6,S:5,D:2,1,-11)+)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(39, 'Dish_Network', '{57.6k,400}<1,-7|1,-4>(1,-15,(F:-6,S:5,D:5,1,-15)+)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(40, 'Elan', '{40.2k,398,msb}<1,-1|1,-2>(3,-2,D:8,~D:8,2,-2,F:8,~F:8,1,^50m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(41, 'Emerson', '{36.7k,872}<1,-1|1,-3>(4,-4,D:6,F:6,~D:6,~F:6,1,-39)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(42, 'F12', '{37.9k,422}<1,-3|3,-1>((D:3,S:1,F:8,-80)2,-128)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'A and B are subsumed into F, and the value of H is computed by the executor. H=A^B. '),
(43, 'F32', '{37.9k,422,msb}<1,-3|3,-1>(D:8,S:8,F:8,E:8,-100m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The meaning of the 32 bits of data is unknown, and the assignment to D, S, F, and E is arbitrary'),
(44, 'Fujitsu', '{37k,432}<1,-1|1,-3>(8,-4,20:8,99:8,0:4,E:4,D:8,S:8,F:8,1,-110)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Fujitsu is the member of the Kaseikyo family with OEM_code1=20 and OEM_code2=99. There is no check byte, so the risk of an incorrectly decoded OBC is much higher than in other Kaseikyo protocols.'),
(45, 'Fujitsu_56', '{37k,432}<1,-1|1,-3>(8,-4,20:8,99:8,0:4,E:4,D:8,S:8,X:8,F:8,1,-110)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(46, 'GI_Cable', '{38.7k,490}<1,-4.5|1,-9>(18,-9,F:8,D:4,C:4,1,-84,(18,-4.5,1,-178)*) {C = -(D + F:4 + F:4:4)}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(47, 'GI_4DTV', '{37.3k,992}<1,-1|1,-3>(5,-2,F:6,D:2,C:4,1,-60)+ {C= ((#(F&25) + #(D&5))&1) + 2*((#(F&43) + #(D&7))&1) + 4*((#(F&22) + # (D&7))&1) + 8*((#(F&44) + #(D&6))&1)}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Unit (device) numbers from 0 to 7 are supported. The check sum C is a Hamming Code, which can correct single bit errors. D:1:2 is encoded in the check sum.'),
(48, 'GI_RG', '{37.3k,1000, msb}<1,-1|1,-3>(5,-3,F:6,S:2,D:8,1,-60)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The SIM2 which has nearly identical timing. Typical usage is the GI/Next Level/Motorola RG2x00 series'),
(49, 'Grundig16', '{35.7k,578,msb}<-4,2|-3,1,-1,1|-2,1,-2,1|-1,1,-3,1> (806u,-2960u,1346u,T:1,F:8,D:7,-100)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, ' Grundig16_30 (30.3K) These are two variants of the same protocol, differing only in frequency.'),
(50, 'GXB', '{38.3k,520,msb}<1,-3|3,-1>(1,-1,D:4,F:8,P:1,1,^80m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Decoder for a nonstandard Xbox remote.'),
(51, 'Humax_4Phase', '{56k,105, msb}<-2,2|-3,1|1,-3|2,-2>(T=0,(2,-2,D:6,S:6,T:2,F:7,~F:1,^95m,T=1)+)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The allocation of bits to device and subdevice (D:6, S:6) is a guess.'),
(52, 'IODATAn', ' {38k,550}<1,-1|1,-3>(16,-8,X:7,D:7,S:7,Y:7,F:8,C:4,1,^108m)+ {n = F:4 ^ F:4:4 ^ C:4} ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'This is potentially a class of protocols distinguished by values of n, x and y with n = 0..15 and x, y = 0..127. If x and y are both zero, they are omitted. The only known example is IODATA1'),
(53, 'Jerrold', '{0k,44}<1,-7.5m|1,-11.5m>(F:5,1,-23.5m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(54, 'JVC', '{38k,525}<1,-1|1,-3>(16,-8,(D:8,F:8,1,-45)+)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, ' It is also very similar in structure and timing to Mitsubishi protocol,'),
(55, 'JVC_48', '{37k,432}<1,-1|1,-3>(8,-4,3:8,1:8,D:8,S:8,F:8,(D^S^F):8,1,-173)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'JVC-48 is the member of the Kaseikyo family with M=3 and N=1.'),
(56, 'JVC_56', '{37k,432}<1,-1|1,-3>(8,-4,3:8,1:8,D:8,S:8,X:8,F:8,(D^S^X^F):8,1,-173)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'JVC-56 is the member of the Kaseikyo56 family with M=3 and N=1.'),
(57, 'Kaseikyo', '{37k,432}<1,-1|1,-3>(8,-4,M:8,N:8,X:4,D:4,S:8,F:8,G:8,1,-173)+ {X=M:4:0^M:4:4^N:4:0^N:4:4}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Kaseikyo is a family of protocols that includes Panasonic, Mitsubishi-K, Fujitsu, JVC-48, Denon-K, Sharp-DVD and Teac-K. Each manufacturer is assigned a pair of identifiers, here identified as M and N'),
(58, 'Kaseikyo56', '{37k,432}<1,-1|1,-3>(8,-4,M:8,N:8,X:4,D:4,S:8,E:8,F:8,G:8,1,-173)+ {X=M:4:0^M:4:4^N:4:0^N:4:4}', './documents/protocols/Interpreting_IR_Signals.pdf', ' Like Kaseikyo, each manufactu', NULL),
(59, 'Kathrein', ' {38k,540}<1,-1|1,-3>(16,-8,D:4,~D:4,F:8,~F:8,1,^105m,(16,-8,F:8,1,^105m)+) ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'This protocol signals repeats by the use of dittos. It is unusual in that the ditto frame carries part of the signal data, specifically the function code (OBC) but not the device code. Similar to Logitech'),
(60, 'Konka', '{38k,500,msb}<1,-3|1,-5>(6,-6,D:8,F:8,1,-8,1,-46)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(61, 'Lumagen', '{38.4k,416,msb}<1,-6|1,-12>(D:4,C:1,F:7,1,-26)+ {C = (#F+1)&1}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(62, 'Lutron', '{40k,2300,msb}<-1|1>(255:8,X:24,0:4)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'This is an unusual protocol in that an 8-bit device code and 8-bit OBC are encoded in a 24-bit error-correcting code as the X of the IRP notation. This is constructed as follows. First two parity bits are appended to the 16 data bits to give even parity for the two sets of 9 bits taken alternately. The resulting 18-bit sequence is then treated as 6 octal digits (0-7) expressed in 3-bit binary code. These are then re-coded in the 3-bit Gray code (also called, more descriptively, the reflected-binary code) with a parity bit to give odd parity, so giving 6 4-bit groups treated as a single 24-bit sequence. The whole thing allows any single-bit error in transmission to be identified and corrected. '),
(63, 'Logitech', '{38k,127}<3,-4|3,-8>(31,-36,D:4,~D:4,F:8,~F:8,3,-50m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Logitech is used with their PS3 adapter. The IR signal is similar to Kathrein.'),
(64, 'Matsui', '{38K,525}<1,-1|1,-3>(D:3,F:7,1,^30.5m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(65, 'MCE', ' {36k,444,msb}<-1,1|1,-1>(6,-2,1:1,6:3,-2,2,OEM1:8,OEM2:8,T:1,D:7,F:8,^107m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'MCE is a member of the RC6 family. Technically it is RC6-6-32 with the standard toggle bit zero, with the OEM1 field equal to 128, and with a nonstandard (for the RC6 family) toggle bit added.'),
(66, 'Metz19', ' (37.9K,106,msb)<4,-9|4,-16>(8,-22,T:1,D:3,~D:3,F:6,~F:6,4,-125m)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The toggle bit T is inverted each time a new button press occurs.'),
(67, 'Mitsubishi', '{32.6k,300}<1,-3|1,-7>(D:8,F:8,1,-80)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, ' It is also very similar in structure and timing to JVC{2} protocol'),
(68, 'Mitsubishi_K', '{37k,432}<1,-1|1,-3>(8,-4,35:8,203:8,X:4,D:8,S:8,F:8,T:4,1,-100)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Mitsubishi-K is the member of the Kaseikyo family with OEM_code1=35 and OEM_code2=203.'),
(69, 'NEC1', '{38.0k,564}<1,-1|1,-3>(16,-8,D:8,S:8,F:8,~F:8,1,^108m,(16,-4,1,^108m)*)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'For NEC1, NEC2, NECx1, and NECx2 protocols, the IRstream contains D:8,S:8,F:8,~F:8 However, some manufacturers (especially Yamaha and Onkyo) are breaking the "rule" that the 4th byte should be ~F:8 Version 2.42 decodes these variants by adding suffixes to the protocol name depending on the IRstream: -y1: D:8,S:8,F:8,~F:7,F:1:7 (complement all of F except the MSB) -y2: D:8,S:8,F:8,F:1,~F:7:1 (complement all of F except the LSB) -y3: D:8,S:8,F:8,F:1,~F:6:1,F:1:7 (complement all of F except MSB and LSB) -rnc: D:8,S:8,F:8;~F:4:4,~F:4 (complement F and reverse the nibbles) -f16: D:8,S:8,F:8,E:8 (no relationship between the 3rd and 4th bytes)'),
(70, 'NEC2', '{38.0k,564}<1,-1|1,-3>(16,-8,D:8,S:8,F:8,~F:8,1,^108m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Pioneer is distinguished from NEC2 only by frequency. All Pioneer signals should have a device number in the range 160 to 175 and no subdevice. No NEC2 signal should fit those rules.'),
(71, 'NECx1', '{38.0k,564}<1,-1|1,-3>(8,-8,D:8,S:8,F:8,~F8,1,^108m,(8,-8,D:1,1,^108m)*)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Most, but not all NECx1 signals have S=D'),
(72, 'NECx2', '{38.0k,564}<1,-1|1,-3>(8,-8,D:8,S:8,F:8,~F8,1,^108m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Most, but not all NECx2 signals have S=D'),
(73, 'Nokia', '{36k,msb}<164,-276|164,-445|164,-614|164,-783>(412,-276,D:8,S:8,F:8,164,^100m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(74, 'Nokia12', '{36k,msb}<164,-276|164,-445|164,-614|164,-783>(412,-276,D:4,F:8,164,^100m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(75, 'Nokia32', '{36k,msb}<164,-276|164,-445|164,-614|164,-783>(412,-276,D:8,S:8,T:1,X:7,F:8,164,^100m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The Nokia32 protocol is one variation of the RCMM 1.5 protocol developed by Philips. RCMM refers to X as "System" and to D:2,S:4:4 as "Customer"'),
(76, 'NRC17', '{500,38k,25%}<-1,1|1,-1>(1,-5,1:1,254:8,255:8,-28, (1,-5,1:1,F:8,D:8,-220)+, 1,-5,1:1,254:8,255:8,-200)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(77, 'OrtekMCE', '{38.6k,480}<1,-1|-1,1>([P=0][P=1][P=2],4,-1,D:5,P:2,F:6,C:4,-48m)+{C=3+#D+#P+#F}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The repeat frames are not all identical. P is a position code: 0 for the start frame of a repeat sequence, 2 for the end frame and 1 for all frames in between. C is a checksum, 3 more than the number of 1 bits in D, P, F together.'),
(78, 'Pace_MSS', '{38k,630,msb}<1,-7|1,-11>(1,-5,1,-5,T:1,D:1,F:8,1,^120m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(79, 'Panasonic', '{37k,432}<1,-1|1,-3>(8,-4,2:8,32:8,D:8,S:8,F:8,(D^S^F):8,1,-173)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Panasonic protocol is the most commonly seen member of the Kaseikyo family OEM_code1 is 2 and OEM_code2 is 32'),
(80, 'Panasonic2', '{37k,432}<1,-1|1,-3>(8,-4,2:8,32:8,D:8,S:8,X:8,F:8,(D^S^X^F):8,1,-173)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(81, 'Panasonic_Old', ' {57.6k,833}<1,-1|1,-3>(4,-4,D:5,F:6,~D:5,~F:6,1,-44m)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(82, 'PCTV', ' {38.4k,832}<0,-1|1,-0>(2,-8,1,D:8,F:8,2,-44m)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(83, 'pid_0001', ' {0k,msb}<24,-9314|24,-13486>(24,-21148,(F:5,1,-28m)+) ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(84, 'pid_0003', ' {40.2k,389}<2,-2|3,-1>(F:8,~F:8,^102k)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(85, 'pid_0004', '{0k,msb}<12,-130|12,-372>(F:6,12,-27k)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(86, 'pid_0083', '{42.3K, 3000}<1,-3,1,-7|1,-7,1,-3>(F:5,1,-27)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'We have seen it used only in some TVs brand named Fisher, Sanyo and Sears.'),
(87, 'Pioneer', ' {40k,564}<1,-1|1,-3>(16,-8,D:8,S:8,F:8,~F:8,1,^108m)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Pioneer is distinguished from NEC2 only by frequency. All Pioneer signals should have a device number in the range 160 to 175 and no subdevice. No NEC2 signal should fit those rules.'),
(88, 'Proton', '{38k,500}<1,-1|1,-3>(16,-8,D:8,1,-8,F:8,1,^63m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(89, 'RC5', '{36k,msb,889}<1,-1|-1,1>(1,~F:1:6,T:1,D:5,F:6,^114m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'What we call "device" is really the "System" and what we call "OBC" is really the "Command": Philips terminology.'),
(90, 'RC5_7F', ' {36k,msb,889}<1,-1|-1,1>(1, ~D:1:5,T:1,D:5,F:7,^114m)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(91, 'RC5_7F_57', '{57k,msb,889}<1,-1|-1,1>(1, ~D:1:5,T:1,D:5,F:7,^114m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(92, 'RC5x', '{36k,msb,889}<1,-1|-1,1>(1,~S:1:6,T:1,D:5,-4,S:6,F:6,^114m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'What we call "Device" is really the "System". What we call Subdevice is really the "Command". What we call "OBC" is really the "Data": Philips terminology.'),
(93, 'RC6', '{36k,444,msb}<-1,1|1,-1>(6,-2,1:1,0:3,<-2,2|2,-2>(T:1),D:8,F:8,^107m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Technically this is RC6-0-16, r the first member of the RC6 family of protocols'),
(94, 'RC6_6_20', '{36k,444,msb}<-1,1|1,-1>(6,-2,1:1,6:3,<-2,2|2,-2>(T:1),D:8,S:4,F:8,-???)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'This protocol is commonly used in Sky and Sky+ remotes, '),
(95, 'RCA', '{58k,460,msb}<1,-2|1,-4>(8,-8,D:4,F:8,~D:4,~F:8,1,-16)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'RCA_38:  variant of the RCA protocol. They differ from RCA only in the frequency, which is 38.7kHz instead of the standard 58kHz.'),
(96, 'RCA_Old', '{58k,460,msb}<1,-2|1,-4>(32,(8,-8,D:4,F:8,~D:4,~F:8,2,-16)+)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'RCA_Old_38:  variant of the RCA protocol. They differ from RCA_Old only in the frequency, which is 38.7kHz instead of the standard 58kHz.'),
(97, 'RECS80', '{38k,158,msb}<1,-31|1,-47>(1:1,T:1,D:3,F:6,1,-45m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'RECS80 is a family of related protocols with the same structure, but different timing. See also Velleman'),
(98, 'Replay', '{36k,444,msb}<-1,1|1,-1>(6,-2,1:1,6:3,<-2,2|2,-2>(T:1),D:8,S:8,F:8,-100m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Replay is a member of the RC6 family. Technically it is RC6-6-24'),
(99, 'Revox', '{0k,15u}<1,-9|1,-19>(1:1,-10,0:1,D:4,F:6,1:1,-10,1:1,-100m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(100, 'Samsung20', ': {38.4k,564}<1,-1|1,-3>(8,-8,D:6,S:6,F:8,1,^100)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(101, 'Samsung36', '{38k,500}<1,-1|1,-3>(9,-9,D:8,S:8,1,-9,E:4,F:8,-68u,~F:8,1,-118)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(102, 'Sampo', '{38.4k, 833}<1,-1|1,-3>(4,-4,D:6,F:6,S:6,~F:6,1,-39)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(103, 'Sejin_M_38', '{38.8k,310,msb}<-1|1>(<8:4|4:4|2:4|1:4>(3,3:2,Dx:8,Fx:8,Fy:8,E:4,C:4,-L))+{C = Dx:4 + Dx:4:4 + Fx:4 + Fx:4:4 + Fy:4 + Fy:4:4 + E}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The parameter M is either 1 or 2. It distinguishes two styles of this protocol that have different purposes and very different lead-out times L. The 8-bit parameter Dx is a signed integer. If Dx > 0 then the style is Sejin-1, used for normal buttons of a remote control. If Dx < 0 then the style is Sejin-2, used for signals of an associated 2- or 3-button pointing device. E is a checksum seed, E=0 in the only known examples. '),
(104, 'Sejin_M_56', '{56.3k,310,msb}<-1|1>(<8:4|4:4|2:4|1:4>(3,3:2,Dx:8,Fx:8,Fy:8,E:4,C:4,-L))+{C = Dx:4 + Dx:4:4 + Fx:4 + Fx:4:4 + Fy:4 + Fy:4:4 + E}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The parameter M is either 1 or 2. It distinguishes two styles of this protocol that have different purposes and very different lead-out times L. The 8-bit parameter Dx is a signed integer. If Dx > 0 then the style is Sejin-1, used for normal buttons of a remote control. If Dx < 0 then the style is Sejin-2, used for signals of an associated 2- or 3-button pointing device. E is a checksum seed, E=0 in the only known examples. '),
(105, 'Sharp', '{38k,264}<1,-3|1,-7>(D:5,F:8,1:2,1,-165,D:5,~F:8,2:2,1,-165)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Sharp signal is identical to Denon'),
(106, 'SharpDVD', ' {38k,400}<1,-1|1,-3>(8,-4,170:8,90:8,15:4,D:4,S:8,F:8,E:4,C:4,1,-48)+ {E=1,C=D^S:4:0^S:4:4^F:4:0^F:4:4^E:4} ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'SharpDVD is the member of the Kaseikyo family with OEM_code1=170 and OEM_code2=90.'),
(107, 'SIM2', '{38.8k,400}<3,-3|3,-7>(6,-7,D:8,F:8,3,-60m)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Nearly identical timing to GI_RG'),
(108, 'Solidtek16', '{38k}<-624,468|468,-624>(S=0,(1820,-590,0:1,D:4,F:7,S:1,C:4,1:1,-143m,S=1)3) {C= F:4:0 + F:3:4 + 8*S }', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'This is a KeyBoard protocol. The make/break bit is decoded into the subdevice field. Checksum is only known to be correct for D = 0'),
(109, 'Solidtek20', '{38k}<-624,468|468,-624>(1820,-590,0:1,D:4,S:6,F:6,C:4,1:1,-45)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'This is a mouse protocol. The button press info is included in the Device field. The horizontal motion is in the Subdevice field, and the vertical motion is in the OBC field. The decode interface does not support returning negative Subdevice or OBC. So negative motions are represented by adding 64 to them. The numbers 1 to 31 represent positive motion. The numbers 32 to 63 are each 64 larger than the true negative motion, so 63 represents -1 and 32 represents -32.'),
(110, 'Somfy', ': {35.7k}<308,-881|669,-520>(2072,-484,F:2,D:3,C:4,-2300)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'C is reported as SubDevice. It is probably a check nibble {C = F*4 + D + 3}. F = 1 for UP or 2 for DOWN. D = 1, 2 or 3 for the three observed devices, or D = 0 to control all devices together.'),
(111, 'Sony8', ' {40k,600}<1,-1|2,-1>(4,-1,F:8,^22200) ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(112, 'Sony12', '{40k,600}<1,-1|2,-1>(4,-1,F:7,D:5,^45m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(113, 'Sony15', '{40k,600}<1,-1|2,-1>(4,-1,F:7,D:8,^45m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(114, 'Sony20', '{40k,600}<1,-1|2,-1>(4,-1,F:7,D:5,S:8,^45m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(115, 'StreamZap', '{36k,msb,889}<1,-1|-1,1>(1,~F:1:6,T:1,D:6,F:6,^114m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(116, 'StreamZap_57', '{57k,msb,889}<1,-1|-1,1>(1,~F:1:6,T:1,D:6,F:6,^114m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(117, 'Sunfire', '(38k,560,msb)<1,-1|3,-1>(16,-8, D:4,F:8,~D:4,~F:8, -32)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(118, 'TDC_38', '{38k,315,msb}<-1,1|1,-1>(1,-1,D:5,S:5,F:7,-89m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, ' TDC-38 has a 38kHz carrier and is used by Danish TDC IPTV. '),
(119, 'TDC_56', '{56.3k,213,msb}<-1,1|1,-1>(1,-1,D:5,S:5,F:7,-89m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'TDC-56 has a 56.3kHz carrier and is used by Italian ALICE Home TV box.'),
(120, 'Teac_K', '{37k,432}<1,-1|1,-3>(8,-4,67:8,83:8,X:4,D:4,S:8,F:8,T:8,1,-100,(8,-8,1,-100)+ {T=D+S:4:0+S:4:4+F:4:0+F:4:4}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Teac-K is the member of the Kaseikyo family with OEM_code1=67 and OEM_code2=83. Teac-K uses different repeat rules and a different check byte than other Kaseikyo protocols.'),
(121, 'Thomson', '{33k,500}<1,-4|1,-9>(D:4,T:1,D:1:5,F:6,1,^80m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(122, 'Thomson7', '{33k,500}<1,-4|1,-9>(D:4,T:1,F:7,1,^80m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(123, 'Tivo', '{38.4k,564}<1,-1|1,-3>(16,-8,133:8,48:8,F:8,U:4,~F:4:4,1,-78,(16,-4,1,-173)*)', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(124, 'Velleman', '{38k,msb}<700,-5060|700,-7590>(1:1,T:1,D:3,F:6,1,-55m)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Very similar to RECS80-0045, except on duration is longer'),
(125, 'Velodyne', '{38k,136,msb}<210,-760> (<0:1|0:1,-1|0:1,-2|0:1,-3|0:1,-4|0:1,-5|0:1,-6|0:1,-7|0:1,-8|0:1,-9|0:1,-10|0:1,-11|0:1,-12|0:1,-13|0:1,-14|0:1,-15> (T=0,(S:4:4,~C:4,S:4,15:4,D:4,T:4,F:8,210u,-79m,T=8)+)) {C=(8+S:4+S:4:4+15+D+T+F:4+F:4:4)&15}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'Velodyne is a close relative of XMP.'),
(126, 'Viewstar', '{50.5k,337}<1,-8|1,-5>(F:5,1,-17)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, NULL),
(127, 'X10', ' {40.8k,565}<2,-12|7,-7>(7,-7,F:5,~F:5,21,-7)+', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The repeat frames, and all frames of the X10 version, only carry the OBC. '),
(128, ' X10_n', ' {40.8k,565}<2,-12|7,-7>(F:5,N:-4,21,-7,(7,-7,F:5,~F:5,21,-7)+) ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The value of n runs from 0 to 15 (or some lower value) and then restarts again at 0. It is incremented on each successive keypress. A valid X10.n signal must have at least one repeat frame. '),
(129, 'XMP', '{38k,136,msb}<210,-760> (<0:1|0:1,-1|0:1,-2|0:1,-3|0:1,-4|0:1,-5|0:1,-6|0:1,-7|0:1,-8|0:1,-9|0:1,-10|0:1,-11|0:1,-12|0:1,-13|0:1,-14|0:1,-15>(T=0, ((S:4:4,C1:4,S:4,15:4,OEM:8,D:8,210u,-13.8m,S:4:4,C2:4,T:4,S:4,F:16,210u,[-80.4m][-80.4m][-13.8m],T=8)+,T=9)2)){C1=(S+S::4+15+OEM+OEM::4+D+D::4),C2=-(S+S:4+T+F+F::4+F::8+F::12)}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'The Device code is D, the SubDevice code is S and there are two OBC values. OBC1 is the high byte of F, OBC2 is the low byte of F. The OEM code is normally 0x44 This protocol has a 4-bit toggle T that is 0 for the first frame and normally 8 for all repeat frames. There is, however, a variant in which a further frame with T=9 is sent after the button is released, separated from the preceding frame by the short leadout of 13.8m that is used between two half-frames rather than the long lead-out of 80.4m used at the end of all other frames. '),
(130, 'Zaptor', '{36k,330,msb}<-1,1|1,-1>[T=0] [T=0] [T=1] (8,-6,2,D:8,T:1,S:7,F:8,E:4,C:4,-74m)+ {C = (D:4+D:4:4+S:4+S:3:4+8*T+F:4+F:4:4+E)&15}', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'A protocol so far seen only in the Motorola Zaptor. See also Amino'),
(131, 'Zenith', ' {40k,520,msb}<1,-10|1,-1,1,-8>(S:1,<1:2|2:2>(F:D),-90m)+ ', './documents/protocols/Interpreting_IR_Signals.pdf', NULL, 'An unusual protocol, in that the number of bits in the function code is variable. There are also two leadin styles, decoded as subdevice values 0 and 1. Style 1 aka "double-start" is usually used in TV''s, other appliances use 0 aka "single start". If the device code is >8 then the bytes given in the Misc field as E = ... follow the OBC in the function code value.');
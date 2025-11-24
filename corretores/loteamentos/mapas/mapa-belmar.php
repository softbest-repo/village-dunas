<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa com Imagem JPG e D3.js</title>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <style>
        body {
            margin: 0;
            overflow: hidden; /* Impede rolagem */
            display: flex;
            justify-content: center; /* Centraliza horizontalmente */
            align-items: flex-start; /* Alinha no topo verticalmente */
            height: 100vh; /* Altura da viewport */
            font-family:Sans-serif;
        }
        svg {
            border: 1px solid #ccc; /* Apenas para visualização */
            width: 100%; /* Largura total */
            height: 100vh; /* Altura total da tela */
        }
    </style>
</head>
<body>
    <svg id="canvas"></svg>
    
    <script>
        const svg = d3.select("#canvas");
        let imgWidth, imgHeight;
        const imgUrl = "mapa-belmar.jpg";
        const img = new Image();
        img.src = imgUrl;
        img.onload = () => {
            imgWidth = img.width;
            imgHeight = img.height;

            const screenWidth = window.innerWidth;
            const initialScale = Math.min(screenWidth / imgWidth, 1);
            const minScale = initialScale;

            svg.attr("width", screenWidth)
               .attr("height", window.innerHeight);

            const g = svg.append("g")
                .attr("transform", `translate(${(screenWidth - imgWidth * initialScale) / 2}, 0) scale(${initialScale})`); // Ajuste inicial no topo

            g.append("image")
                .attr("xlink:href", imgUrl)
                .attr("width", imgWidth)
                .attr("height", imgHeight)
                .attr("preserveAspectRatio", "xMinYMin meet")
                .attr("x", 0)
                .attr("y", 0);

            const areas = [
				// Quadra 1
                {cod: '0101', coords: [2141, 38, 2188, 191], href: 'link1.html', status: 'V', numero: '01' },
                {cod: '0102', coords: [2186, 38, 2233, 191], href: 'link2.html', status: 'V', numero: '02' },
                {cod: '0103', coords: [2233, 38, 2279, 191], href: 'link3.html', status: 'V', numero: '03' },
                {cod: '0104', coords: [2278, 38, 2330, 191], href: 'link4.html', status: 'V', numero: '04' },
                {cod: '0105', coords: [2328, 38, 2373, 191], href: 'link5.html', status: 'V', numero: '05' },
                {cod: '0106', coords: [2375, 38, 2419, 191], href: 'link6.html', status: 'V', numero: '06' },
                {cod: '0107', coords: [2462, 38, 2421, 191], href: 'link7.html', status: 'V', numero: '07' },
                {cod: '0108', coords: [2510, 38, 2465, 191], href: 'link8.html', status: 'V', numero: '08' },
                // Quadra 2
                {cod: '0201', coords: [2139,372,2187,488], href: 'link8.html', status: 'V', numero: '01' },                
                {cod: '0202', coords: [2189,372,2234,488], href: 'link8.html', status: 'V', numero: '02' },                
                {cod: '0203', coords: [2236,372,2280,488], href: 'link8.html', status: 'V', numero: '03' },                
                {cod: '0204', coords: [2281,372,2327,488], href: 'link8.html', status: 'V', numero: '04' },                
                {cod: '0205', coords: [2328,372,2373,488], href: 'link8.html', status: 'V', numero: '05' },                
                {cod: '0206', coords: [2374,372,2420,488], href: 'link8.html', status: 'V', numero: '06' },                
                {cod: '0207', coords: [2422,372,2468,488], href: 'link8.html', status: 'V', numero: '07' },                
                {cod: '0208', coords: [2468,372,2512,488], href: 'link8.html', status: 'V', numero: '08' },                
                {cod: '0209', coords: [2140,254,2187,370], href: 'link8.html', status: 'V', numero: '09' },                
                {cod: '0210', coords: [2187,254,2234,370], href: 'link8.html', status: 'V', numero: '10' },                
                {cod: '0211', coords: [2234,254,2280,370], href: 'link8.html', status: 'V', numero: '11' },                
                {cod: '0212', coords: [2281,254,2326,370], href: 'link8.html', status: 'V', numero: '12' },                
                {cod: '0213', coords: [2327,254,2372,370], href: 'link8.html', status: 'V', numero: '13' },                
                {cod: '0214', coords: [2374,254,2419,370], href: 'link8.html', status: 'V', numero: '14' },                
                {cod: '0215', coords: [2419,254,2466,370], href: 'link8.html', status: 'V', numero: '15' },                
                {cod: '0216', coords: [2467,254,2513,370], href: 'link8.html', status: 'V', numero: '16' },                
                // Quadra 3
				{cod: '0301', coords: [2140, 665, 2187, 782], href: 'link8.html', status: 'V', numero: '01' },
				{cod: '0302', coords: [2188, 665, 2234, 782], href: 'link8.html', status: 'V', numero: '02' },
				{cod: '0303', coords: [2234, 665, 2280, 782], href: 'link8.html', status: 'V', numero: '03' },
				{cod: '0304', coords: [2280, 665, 2328, 782], href: 'link8.html', status: 'V', numero: '04' },
				{cod: '0305', coords: [2328, 665, 2372, 782], href: 'link8.html', status: 'V', numero: '05' },
				{cod: '0306', coords: [2372, 665, 2420, 782], href: 'link8.html', status: 'V', numero: '06' },
				{cod: '0307', coords: [2420, 665, 2465, 782], href: 'link8.html', status: 'V', numero: '07' },
				{cod: '0308', coords: [2465, 665, 2512, 782], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '0309', coords: [2140, 549, 2186, 665], href: 'link8.html', status: 'V', numero: '09' },
				{cod: '0310', coords: [2186, 549, 2235, 665], href: 'link8.html', status: 'V', numero: '10' },
				{cod: '0311', coords: [2235, 549, 2279, 665], href: 'link8.html', status: 'V', numero: '11' },
				{cod: '0312', coords: [2279, 549, 2327, 665], href: 'link8.html', status: 'V', numero: '12' },
				{cod: '0313', coords: [2327, 549, 2372, 665], href: 'link8.html', status: 'V', numero: '13' },
				{cod: '0314', coords: [2372, 549, 2419, 665], href: 'link8.html', status: 'V', numero: '14' },
				{cod: '0315', coords: [2419, 549, 2467, 665], href: 'link8.html', status: 'V', numero: '15' },
				{cod: '0316', coords: [2467, 549, 2512, 665], href: 'link8.html', status: 'V', numero: '16' },             
                // Quadra 4
				{cod: '0401', coords: [2141, 960, 2186, 1077], href: 'link8.html', status: 'V', numero: '01' },
				{cod: '0402', coords: [2186, 960, 2233, 1077], href: 'link8.html', status: 'V', numero: '02' },
				{cod: '0403', coords: [2233, 960, 2279, 1077], href: 'link8.html', status: 'V', numero: '03' },
				{cod: '0404', coords: [2279, 960, 2328, 1077], href: 'link8.html', status: 'V', numero: '04' },
				{cod: '0405', coords: [2328, 960, 2373, 1077], href: 'link8.html', status: 'V', numero: '05' },
				{cod: '0406', coords: [2373, 960, 2421, 1077], href: 'link8.html', status: 'V', numero: '06' },
				{cod: '0407', coords: [2421, 960, 2467, 1077], href: 'link8.html', status: 'V', numero: '07' },
				{cod: '0408', coords: [2467, 960, 2513, 1077], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '0409', coords: [2141, 843, 2188, 959], href: 'link8.html', status: 'V', numero: '09' },
				{cod: '0410', coords: [2188, 843, 2233, 959], href: 'link8.html', status: 'V', numero: '10' },
				{cod: '0411', coords: [2233, 843, 2281, 959], href: 'link8.html', status: 'V', numero: '11' },
				{cod: '0412', coords: [2281, 843, 2327, 959], href: 'link8.html', status: 'V', numero: '12' },
				{cod: '0413', coords: [2329, 843, 2373, 959], href: 'link8.html', status: 'V', numero: '13' },
				{cod: '0414', coords: [2373, 843, 2419, 959], href: 'link8.html', status: 'V', numero: '14' },
				{cod: '0415', coords: [2419, 843, 2467, 959], href: 'link8.html', status: 'V', numero: '15' },
				{cod: '0416', coords: [2467, 843, 2513, 959], href: 'link8.html', status: 'V', numero: '16' },               
                // Quadra 5
				{cod: '0501', coords: [2141, 1253, 2188, 1369], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '0502', coords: [2188, 1253, 2236, 1369], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '0503', coords: [2236, 1253, 2281, 1369], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '0504', coords: [2281, 1253, 2329, 1369], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '0505', coords: [2329, 1253, 2373, 1369], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '0506', coords: [2373, 1253, 2421, 1369], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '0507', coords: [2421, 1253, 2468, 1369], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '0508', coords: [2468, 1253, 2514, 1369], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '0509', coords: [2141, 1137, 2189, 1253], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '0510', coords: [2189, 1137, 2236, 1253], href: 'link10.html', status: 'V', numero: '10' },
				{cod: '0511', coords: [2236, 1137, 2281, 1253], href: 'link11.html', status: 'V', numero: '11' },
				{cod: '0512', coords: [2281, 1137, 2328, 1253], href: 'link12.html', status: 'V', numero: '12' },
				{cod: '0513', coords: [2328, 1137, 2374, 1253], href: 'link13.html', status: 'V', numero: '13' },
				{cod: '0514', coords: [2374, 1137, 2420, 1253], href: 'link14.html', status: 'V', numero: '14' },
				{cod: '0515', coords: [2421, 1137, 2468, 1253], href: 'link15.html', status: 'V', numero: '15' },
				{cod: '0516', coords: [2467, 1137, 2514, 1253], href: 'link16.html', status: 'V', numero: '16' },          
                // Quadra 6
				{cod: '0601', coords: [2142, 1549, 2189, 1667], href: 'link8.html', status: 'V', numero: '01' },
				{cod: '0602', coords: [2189, 1549, 2235, 1667], href: 'link8.html', status: 'V', numero: '02' },
				{cod: '0603', coords: [2235, 1549, 2282, 1667], href: 'link8.html', status: 'V', numero: '03' },
				{cod: '0604', coords: [2282, 1549, 2329, 1667], href: 'link8.html', status: 'V', numero: '04' },
				{cod: '0605', coords: [2329, 1549, 2374, 1667], href: 'link8.html', status: 'V', numero: '05' },
				{cod: '0606', coords: [2374, 1549, 2421, 1667], href: 'link8.html', status: 'V', numero: '06' },
				{cod: '0607', coords: [2421, 1549, 2466, 1667], href: 'link8.html', status: 'V', numero: '07' },
				{cod: '0608', coords: [2466, 1549, 2514, 1667], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '0609', coords: [2142, 1433, 2189, 1549], href: 'link8.html', status: 'V', numero: '09' },
				{cod: '0610', coords: [2189, 1433, 2236, 1549], href: 'link8.html', status: 'V', numero: '10' },
				{cod: '0611', coords: [2237, 1433, 2281, 1549], href: 'link8.html', status: 'V', numero: '11' },
				{cod: '0612', coords: [2281, 1433, 2329, 1549], href: 'link8.html', status: 'V', numero: '12' },
				{cod: '0613', coords: [2329, 1433, 2374, 1549], href: 'link8.html', status: 'V', numero: '13' },
				{cod: '0614', coords: [2374, 1433, 2421, 1549], href: 'link8.html', status: 'V', numero: '14' },
				{cod: '0615', coords: [2421, 1433, 2467, 1549], href: 'link8.html', status: 'V', numero: '15' },
				{cod: '0616', coords: [2467, 1433, 2514, 1549], href: 'link8.html', status: 'V', numero: '16' },         
                // Quadra 7
				{cod: '0701', coords: [2142, 1845, 2188, 1963], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '0702', coords: [2188, 1845, 2237, 1963], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '0703', coords: [2236, 1845, 2282, 1963], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '0704', coords: [2282, 1845, 2330, 1963], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '0705', coords: [2330, 1845, 2375, 1963], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '0706', coords: [2375, 1845, 2423, 1963], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '0707', coords: [2423, 1845, 2467, 1963], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '0708', coords: [2467, 1845, 2514, 1963], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '0709', coords: [2143, 1729, 2188, 1844], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '0710', coords: [2188, 1729, 2235, 1844], href: 'link10.html', status: 'V', numero: '10' },
				{cod: '0711', coords: [2235, 1729, 2281, 1844], href: 'link11.html', status: 'V', numero: '11' },
				{cod: '0712', coords: [2281, 1729, 2330, 1844], href: 'link12.html', status: 'V', numero: '12' },
				{cod: '0713', coords: [2330, 1729, 2375, 1844], href: 'link13.html', status: 'V', numero: '13' },
				{cod: '0714', coords: [2375, 1729, 2422, 1844], href: 'link14.html', status: 'V', numero: '14' },
				{cod: '0715', coords: [2422, 1729, 2467, 1844], href: 'link15.html', status: 'V', numero: '15' },
				{cod: '0716', coords: [2467, 1729, 2512, 1844], href: 'link16.html', status: 'V', numero: '16' },         
				// Quadra 12
				{cod: '1201', coords: [1610, 37, 1658, 195], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '1202', coords: [1658, 37, 1705, 195], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '1203', coords: [1705, 37, 1750, 195], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '1204', coords: [1750, 37, 1798, 195], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '1205', coords: [1798, 37, 1844, 195], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '1206', coords: [1843, 37, 1891, 195], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '1207', coords: [1892, 37, 1937, 195], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '1208', coords: [1937, 37, 1984, 195], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '1209', coords: [1984, 37, 2030, 195], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '1210', coords: [2029, 37, 2076, 195], href: 'link10.html', status: 'V', numero: '10' },        
                // Quadra 13
				{cod: '1301', coords: [1611, 371, 1659, 490], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '1302', coords: [1659, 371, 1704, 490], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '1303', coords: [1704, 371, 1751, 490], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '1304', coords: [1751, 371, 1797, 490], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '1305', coords: [1798, 371, 1846, 490], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '1306', coords: [1846, 371, 1891, 490], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '1307', coords: [1891, 371, 1938, 490], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '1308', coords: [1938, 371, 1985, 490], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '1309', coords: [1985, 371, 2030, 490], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '1310', coords: [2030, 371, 2078, 490], href: 'link10.html', status: 'V', numero: '10' },
				{cod: '1311', coords: [1611, 255, 1658, 371], href: 'link11.html', status: 'V', numero: '11' },
				{cod: '1312', coords: [1658, 255, 1705, 371], href: 'link12.html', status: 'V', numero: '12' },
				{cod: '1313', coords: [1705, 255, 1752, 371], href: 'link13.html', status: 'V', numero: '13' },
				{cod: '1314', coords: [1752, 255, 1797, 371], href: 'link14.html', status: 'V', numero: '14' },
				{cod: '1315', coords: [1798, 255, 1845, 371], href: 'link15.html', status: 'V', numero: '15' },
				{cod: '1316', coords: [1845, 255, 1892, 371], href: 'link16.html', status: 'V', numero: '16' },
				{cod: '1317', coords: [1892, 255, 1939, 371], href: 'link17.html', status: 'V', numero: '17' },
				{cod: '1318', coords: [1939, 255, 1984, 370], href: 'link18.html', status: 'V', numero: '18' },
				{cod: '1319', coords: [1984, 255, 2030, 371], href: 'link19.html', status: 'V', numero: '19' },
				{cod: '1320', coords: [2030, 255, 2077, 371], href: 'link20.html', status: 'V', numero: '20' },             
                // Quadra 14
				{cod: '1401', coords: [1612, 666, 1660, 783], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '1402', coords: [1660, 666, 1709, 783], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '1403', coords: [1709, 666, 1752, 783], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '1404', coords: [1752, 666, 1801, 783], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '1405', coords: [1801, 666, 1848, 783], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '1406', coords: [1848, 666, 1893, 783], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '1407', coords: [1893, 666, 1939, 783], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '1408', coords: [1939, 666, 1986, 783], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '1409', coords: [1986, 666, 2033, 783], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '1410', coords: [2033, 666, 2080, 783], href: 'link10.html', status: 'V', numero: '10' },
				{cod: '1411', coords: [1614, 551, 1659, 665], href: 'link11.html', status: 'V', numero: '11' },
				{cod: '1412', coords: [1659, 551, 1707, 665], href: 'link12.html', status: 'V', numero: '12' },
				{cod: '1413', coords: [1707, 551, 1753, 665], href: 'link13.html', status: 'V', numero: '13' },
				{cod: '1414', coords: [1753, 551, 1798, 665], href: 'link14.html', status: 'V', numero: '14' },
				{cod: '1415', coords: [1799, 551, 1845, 665], href: 'link15.html', status: 'V', numero: '15' },
				{cod: '1416', coords: [1845, 551, 1893, 665], href: 'link16.html', status: 'V', numero: '16' },
				{cod: '1417', coords: [1893, 551, 1940, 665], href: 'link17.html', status: 'V', numero: '17' },
				{cod: '1418', coords: [1940, 551, 1985, 665], href: 'link18.html', status: 'V', numero: '18' },
				{cod: '1419', coords: [1985, 551, 2032, 665], href: 'link19.html', status: 'V', numero: '19' },
				{cod: '1420', coords: [2032, 551, 2080, 665], href: 'link20.html', status: 'V', numero: '20' },          
                // Quadra 15
				{cod: '1501', coords: [1613, 961, 1661, 1079], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '1502', coords: [1661, 961, 1708, 1079], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '1503', coords: [1708, 961, 1755, 1079], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '1504', coords: [1754, 961, 1800, 1079], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '1505', coords: [1801, 961, 1847, 1079], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '1506', coords: [1847, 961, 1894, 1079], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '1507', coords: [1894, 961, 1941, 1079], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '1508', coords: [1941, 961, 1987, 1079], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '1509', coords: [1987, 961, 2032, 1079], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '1510', coords: [2032, 961, 2083, 1079], href: 'link10.html', status: 'V', numero: '10' },
				{cod: '1511', coords: [1613, 845, 1661, 961], href: 'link11.html', status: 'V', numero: '11' },
				{cod: '1512', coords: [1661, 845, 1708, 961], href: 'link12.html', status: 'V', numero: '12' },
				{cod: '1513', coords: [1708, 845, 1754, 961], href: 'link13.html', status: 'V', numero: '13' },
				{cod: '1514', coords: [1754, 845, 1801, 961], href: 'link14.html', status: 'V', numero: '14' },
				{cod: '1515', coords: [1801, 845, 1848, 961], href: 'link15.html', status: 'V', numero: '15' },
				{cod: '1516', coords: [1848, 845, 1893, 961], href: 'link16.html', status: 'V', numero: '16' },
				{cod: '1517', coords: [1895, 845, 1940, 961], href: 'link17.html', status: 'V', numero: '17' },
				{cod: '1518', coords: [1940, 845, 1988, 961], href: 'link18.html', status: 'V', numero: '18' },
				{cod: '1519', coords: [1988, 845, 2032, 961], href: 'link19.html', status: 'V', numero: '19' },
				{cod: '1520', coords: [2034, 845, 2081, 961], href: 'link20.html', status: 'V', numero: '20' },       
                // Quadra 16
				{cod: '1601', coords: [1615, 1254, 1662, 1372], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '1602', coords: [1662, 1254, 1708, 1372], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '1603', coords: [1709, 1254, 1754, 1372], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '1604', coords: [1754, 1254, 1803, 1372], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '1605', coords: [1803, 1254, 1849, 1372], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '1606', coords: [1849, 1254, 1895, 1372], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '1607', coords: [1895, 1254, 1941, 1372], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '1608', coords: [1941, 1254, 1989, 1372], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '1609', coords: [1989, 1254, 2036, 1372], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '1610', coords: [2036, 1254, 2082, 1372], href: 'link10.html', status: 'V', numero: '10' },
				{cod: '1611', coords: [1615, 1139, 1661, 1253], href: 'link11.html', status: 'V', numero: '11' },
				{cod: '1612', coords: [1661, 1139, 1709, 1253], href: 'link12.html', status: 'V', numero: '12' },
				{cod: '1613', coords: [1709, 1139, 1755, 1253], href: 'link13.html', status: 'V', numero: '13' },
				{cod: '1614', coords: [1755, 1139, 1802, 1253], href: 'link14.html', status: 'V', numero: '14' },
				{cod: '1615', coords: [1803, 1139, 1849, 1253], href: 'link15.html', status: 'V', numero: '15' },
				{cod: '1616', coords: [1849, 1139, 1895, 1253], href: 'link16.html', status: 'V', numero: '16' },
				{cod: '1617', coords: [1895, 1139, 1943, 1253], href: 'link17.html', status: 'V', numero: '17' },
				{cod: '1618', coords: [1943, 1139, 1987, 1253], href: 'link18.html', status: 'V', numero: '18' },
				{cod: '1619', coords: [1988, 1139, 2035, 1253], href: 'link19.html', status: 'V', numero: '19' },
				{cod: '1620', coords: [2033, 1139, 2081, 1253], href: 'link20.html', status: 'V', numero: '20' },     
                // Quadra 17
				{cod: '1701', coords: [1615, 1551, 1662, 1668], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '1702', coords: [1662, 1551, 1710, 1668], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '1703', coords: [1710, 1551, 1757, 1668], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '1704', coords: [1757, 1551, 1802, 1668], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '1705', coords: [1802, 1551, 1849, 1668], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '1706', coords: [1849, 1551, 1896, 1668], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '1707', coords: [1896, 1551, 1941, 1668], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '1708', coords: [1941, 1551, 1988, 1668], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '1709', coords: [1988, 1551, 2034, 1668], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '1710', coords: [2034, 1551, 2081, 1668], href: 'link10.html', status: 'V', numero: '10' },
				{cod: '1711', coords: [1614, 1436, 1661, 1550], href: 'link11.html', status: 'V', numero: '11' },
				{cod: '1712', coords: [1661, 1436, 1708, 1550], href: 'link12.html', status: 'V', numero: '12' },
				{cod: '1713', coords: [1709, 1436, 1757, 1550], href: 'link13.html', status: 'V', numero: '13' },
				{cod: '1714', coords: [1757, 1436, 1801, 1550], href: 'link14.html', status: 'V', numero: '14' },
				{cod: '1715', coords: [1801, 1436, 1848, 1550], href: 'link15.html', status: 'V', numero: '15' },
				{cod: '1716', coords: [1849, 1436, 1896, 1550], href: 'link16.html', status: 'V', numero: '16' },
				{cod: '1717', coords: [1896, 1436, 1941, 1550], href: 'link17.html', status: 'V', numero: '17' },
				{cod: '1718', coords: [1941, 1436, 1988, 1550], href: 'link18.html', status: 'V', numero: '18' },
				{cod: '1719', coords: [1988, 1436, 2033, 1550], href: 'link19.html', status: 'V', numero: '19' },
				{cod: '1720', coords: [2034, 1436, 2080, 1550], href: 'link20.html', status: 'V', numero: '20' },    
                // Quadra 18
				{cod: '1801', coords: [1614, 1846, 1661, 1965], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '1802', coords: [1661, 1846, 1709, 1965], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '1803', coords: [1709, 1846, 1755, 1965], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '1804', coords: [1755, 1846, 1801, 1965], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '1805', coords: [1802, 1846, 1849, 1965], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '1806', coords: [1849, 1846, 1895, 1965], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '1807', coords: [1895, 1846, 1941, 1965], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '1808', coords: [1941, 1846, 1988, 1965], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '1809', coords: [1988, 1846, 2034, 1965], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '1810', coords: [2034, 1846, 2082, 1965], href: 'link10.html', status: 'V', numero: '10' },
				{cod: '1811', coords: [1615, 1731, 1662, 1845], href: 'link11.html', status: 'V', numero: '11' },
				{cod: '1812', coords: [1662, 1731, 1709, 1845], href: 'link12.html', status: 'V', numero: '12' },
				{cod: '1813', coords: [1709, 1731, 1754, 1845], href: 'link13.html', status: 'V', numero: '13' },
				{cod: '1814', coords: [1754, 1731, 1801, 1845], href: 'link14.html', status: 'V', numero: '14' },
				{cod: '1815', coords: [1801, 1731, 1848, 1845], href: 'link15.html', status: 'V', numero: '15' },
				{cod: '1816', coords: [1849, 1731, 1894, 1845], href: 'link16.html', status: 'V', numero: '16' },
				{cod: '1817', coords: [1895, 1731, 1941, 1845], href: 'link17.html', status: 'V', numero: '17' },
				{cod: '1818', coords: [1942, 1731, 1990, 1845], href: 'link18.html', status: 'V', numero: '18' },
				{cod: '1819', coords: [1989, 1731, 2035, 1845], href: 'link19.html', status: 'V', numero: '19' },
				{cod: '1820', coords: [2035, 1731, 2082, 1845], href: 'link20.html', status: 'V', numero: '20' },   
                // Quadra 23
				{cod: '2301', coords: [1083, 40, 1130, 197], href: 'link1.html', status: 'V', numero: '01' },
				{cod: '2302', coords: [1131, 40, 1178, 197], href: 'link2.html', status: 'V', numero: '02' },
				{cod: '2303', coords: [1178, 40, 1225, 197], href: 'link3.html', status: 'V', numero: '03' },
				{cod: '2304', coords: [1225, 40, 1273, 197], href: 'link4.html', status: 'V', numero: '04' },
				{cod: '2305', coords: [1273, 40, 1318, 197], href: 'link5.html', status: 'V', numero: '05' },
				{cod: '2306', coords: [1318, 40, 1364, 197], href: 'link6.html', status: 'V', numero: '06' },
				{cod: '2307', coords: [1364, 40, 1411, 197], href: 'link7.html', status: 'V', numero: '07' },
				{cod: '2308', coords: [1411, 40, 1457, 197], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '2309', coords: [1457, 40, 1504, 197], href: 'link9.html', status: 'V', numero: '09' },
				{cod: '2310', coords: [1504, 40, 1552, 197], href: 'link10.html', status: 'V', numero: '10' }, 
                // Quadra 24
				{cod: '2401', coords: [1085, 373, 1132, 493], href: 'link8.html', status: 'V', numero: '01' },
				{cod: '2402', coords: [1132, 373, 1179, 493], href: 'link8.html', status: 'V', numero: '02' },
				{cod: '2403', coords: [1179, 373, 1225, 493], href: 'link8.html', status: 'V', numero: '03' },
				{cod: '2404', coords: [1225, 373, 1272, 493], href: 'link8.html', status: 'V', numero: '04' },
				{cod: '2405', coords: [1272, 373, 1319, 493], href: 'link8.html', status: 'V', numero: '05' },
				{cod: '2406', coords: [1320, 373, 1365, 493], href: 'link8.html', status: 'V', numero: '06' },
				{cod: '2407', coords: [1366, 373, 1413, 493], href: 'link8.html', status: 'V', numero: '07' },
				{cod: '2408', coords: [1413, 373, 1460, 493], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '2409', coords: [1460, 373, 1503, 493], href: 'link8.html', status: 'V', numero: '09' },
				{cod: '2410', coords: [1503, 373, 1553, 493], href: 'link8.html', status: 'V', numero: '10' },
				{cod: '2411', coords: [1085, 259, 1133, 373], href: 'link8.html', status: 'V', numero: '11' },
				{cod: '2412', coords: [1133, 259, 1179, 373], href: 'link8.html', status: 'V', numero: '12' },
				{cod: '2413', coords: [1178, 259, 1226, 373], href: 'link8.html', status: 'V', numero: '13' },
				{cod: '2414', coords: [1226, 259, 1273, 373], href: 'link8.html', status: 'V', numero: '14' },
				{cod: '2415', coords: [1273, 259, 1318, 373], href: 'link8.html', status: 'V', numero: '15' },
				{cod: '2416', coords: [1318, 259, 1365, 373], href: 'link8.html', status: 'V', numero: '16' },
				{cod: '2417', coords: [1365, 259, 1410, 373], href: 'link8.html', status: 'V', numero: '17' },
				{cod: '2418', coords: [1410, 259, 1458, 373], href: 'link8.html', status: 'V', numero: '18' },
				{cod: '2419', coords: [1457, 259, 1503, 373], href: 'link8.html', status: 'V', numero: '19' },
				{cod: '2420', coords: [1503, 259, 1551, 373], href: 'link8.html', status: 'V', numero: '20' },              
                // Quadra 25
				{cod: '2501', coords: [1086, 669, 1133, 787], href: 'link8.html', status: 'V', numero: '01' },
				{cod: '2502', coords: [1133, 669, 1179, 787], href: 'link8.html', status: 'V', numero: '02' },
				{cod: '2503', coords: [1180, 669, 1226, 787], href: 'link8.html', status: 'V', numero: '03' },
				{cod: '2504', coords: [1226, 669, 1271, 787], href: 'link8.html', status: 'V', numero: '04' },
				{cod: '2505', coords: [1271, 669, 1319, 787], href: 'link8.html', status: 'V', numero: '05' },
				{cod: '2506', coords: [1319, 669, 1366, 787], href: 'link8.html', status: 'V', numero: '06' },
				{cod: '2507', coords: [1366, 669, 1413, 787], href: 'link8.html', status: 'V', numero: '07' },
				{cod: '2508', coords: [1413, 669, 1460, 787], href: 'link8.html', status: 'V', numero: '08' },
				{cod: '2509', coords: [1460, 669, 1506, 787], href: 'link8.html', status: 'V', numero: '09' },
				{cod: '2510', coords: [1506, 669, 1552, 787], href: 'link8.html', status: 'V', numero: '10' },
				{cod: '2511', coords: [1086, 551, 1133, 668], href: 'link8.html', status: 'V', numero: '11' },
				{cod: '2512', coords: [1133, 551, 1180, 668], href: 'link8.html', status: 'V', numero: '12' },
				{cod: '2513', coords: [1180, 551, 1225, 668], href: 'link8.html', status: 'V', numero: '13' },
				{cod: '2514', coords: [1225, 551, 1273, 668], href: 'link8.html', status: 'V', numero: '14' },
				{cod: '2515', coords: [1273, 551, 1319, 668], href: 'link8.html', status: 'V', numero: '15' },
				{cod: '2516', coords: [1319, 551, 1365, 666], href: 'link8.html', status: 'V', numero: '16' },
				{cod: '2517', coords: [1365, 551, 1411, 668], href: 'link8.html', status: 'V', numero: '17' },
				{cod: '2518', coords: [1411, 551, 1458, 668], href: 'link8.html', status: 'V', numero: '18' },
				{cod: '2519', coords: [1459, 551, 1506, 666], href: 'link8.html', status: 'V', numero: '19' },
				{cod: '2520', coords: [1506, 551, 1552, 668], href: 'link8.html', status: 'V', numero: '20' },             
                // Quadra 26
                {cod: '2601', coords: [1089,963,1136,1078], href: 'link8.html', status: 'V', numero: '01' },                
                {cod: '2602', coords: [1135,963,1181,1078], href: 'link8.html', status: 'V', numero: '02' },                
                {cod: '2603', coords: [1182,963,1228,1078], href: 'link8.html', status: 'V', numero: '03' },                
                {cod: '2604', coords: [1227,963,1273,1078], href: 'link8.html', status: 'V', numero: '04' },                
                {cod: '2605', coords: [1273,963,1320,1078], href: 'link8.html', status: 'V', numero: '05' },                
                {cod: '2606', coords: [1320,963,1366,1078], href: 'link8.html', status: 'V', numero: '06' },                
                {cod: '2607', coords: [1365,963,1413,1078], href: 'link8.html', status: 'V', numero: '07' },                
                {cod: '2608', coords: [1413,963,1459,1078], href: 'link8.html', status: 'V', numero: '08' },                
                {cod: '2609', coords: [1460,963,1505,1078], href: 'link8.html', status: 'V', numero: '09' },                
                {cod: '2610', coords: [1505,963,1552,1078], href: 'link8.html', status: 'V', numero: '10' },                
                {cod: '2611', coords: [1086,846,1133,961], href: 'link8.html', status: 'V', numero: '11' },                
                {cod: '2612', coords: [1134,846,1180,961], href: 'link8.html', status: 'V', numero: '12' },                
                {cod: '2613', coords: [1181,846,1227,961], href: 'link8.html', status: 'V', numero: '13' },                
                {cod: '2614', coords: [1227,846,1273,961], href: 'link8.html', status: 'V', numero: '14' },                
                {cod: '2615', coords: [1273,846,1320,961], href: 'link8.html', status: 'V', numero: '15' },                
                {cod: '2616', coords: [1321,846,1367,961], href: 'link8.html', status: 'V', numero: '16' },                
                {cod: '2617', coords: [1366,846,1413,961], href: 'link8.html', status: 'V', numero: '17' },                
                {cod: '2618', coords: [1413,846,1459,961], href: 'link8.html', status: 'V', numero: '18' },                
                {cod: '2619', coords: [1460,846,1507,961], href: 'link8.html', status: 'V', numero: '19' },                
                {cod: '2620', coords: [1508,846,1552,961], href: 'link8.html', status: 'V', numero: '20' },                
                // Quadra 27
                {cod: '2701', coords: [1089,1256,1135,1372], href: 'link8.html', status: 'V', numero: '01' },                
                {cod: '2702', coords: [1135,1256,1181,1372], href: 'link8.html', status: 'V', numero: '02' },                
                {cod: '2703', coords: [1183,1256,1229,1372], href: 'link8.html', status: 'V', numero: '03' },                
                {cod: '2704', coords: [1229,1256,1275,1372], href: 'link8.html', status: 'V', numero: '04' },                
                {cod: '2705', coords: [1275,1256,1322,1372], href: 'link8.html', status: 'V', numero: '05' },                
                {cod: '2706', coords: [1323,1256,1367,1372], href: 'link8.html', status: 'V', numero: '06' },                
                {cod: '2707', coords: [1369,1256,1414,1372], href: 'link8.html', status: 'V', numero: '07' },                
                {cod: '2708', coords: [1415,1256,1460,1372], href: 'link8.html', status: 'V', numero: '08' },                
                {cod: '2709', coords: [1462,1256,1507,1372], href: 'link8.html', status: 'V', numero: '09' },                
                {cod: '2710', coords: [1508,1256,1553,1372], href: 'link8.html', status: 'V', numero: '10' },                
                {cod: '2711', coords: [1089,1139,1134,1257], href: 'link8.html', status: 'V', numero: '11' },                
                {cod: '2712', coords: [1136,1139,1181,1257], href: 'link8.html', status: 'V', numero: '12' },                
                {cod: '2713', coords: [1181,1139,1227,1257], href: 'link8.html', status: 'V', numero: '13' },                
                {cod: '2714', coords: [1229,1139,1273,1257], href: 'link8.html', status: 'V', numero: '14' },                
                {cod: '2715', coords: [1275,1139,1322,1257], href: 'link8.html', status: 'V', numero: '15' },                
                {cod: '2716', coords: [1323,1139,1367,1257], href: 'link8.html', status: 'V', numero: '16' },                
                {cod: '2717', coords: [1368,1139,1413,1257], href: 'link8.html', status: 'V', numero: '17' },                
                {cod: '2718', coords: [1415,1139,1459,1257], href: 'link8.html', status: 'V', numero: '18' },                
                {cod: '2719', coords: [1460,1139,1506,1257], href: 'link8.html', status: 'V', numero: '19' },                
                {cod: '2720', coords: [1507,1139,1554,1257], href: 'link8.html', status: 'V', numero: '20' },                
                // Quadra 28
				{cod: '2801', coords: [1090, 1553, 1135, 1671], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '2802', coords: [1135, 1553, 1182, 1671], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '2803', coords: [1183, 1553, 1227, 1671], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '2804', coords: [1230, 1553, 1275, 1671], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '2805', coords: [1276, 1553, 1321, 1671], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '2806', coords: [1322, 1553, 1367, 1671], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '2807', coords: [1369, 1553, 1416, 1671], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '2808', coords: [1416, 1553, 1461, 1671], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '2809', coords: [1462, 1553, 1508, 1671], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '2810', coords: [1508, 1553, 1554, 1671], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '2811', coords: [1090, 1437, 1137, 1552], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '2812', coords: [1137, 1437, 1182, 1552], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '2813', coords: [1183, 1437, 1227, 1552], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '2814', coords: [1229, 1437, 1275, 1552], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '2815', coords: [1276, 1437, 1320, 1552], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '2816', coords: [1322, 1437, 1368, 1552], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '2817', coords: [1368, 1437, 1413, 1552], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '2818', coords: [1415, 1437, 1460, 1552], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '2819', coords: [1462, 1437, 1507, 1552], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '2820', coords: [1507, 1437, 1554, 1552], href: 'link8.html', status: 'V', numero: '20'},              
                // Quadra 29
				{cod: '2901', coords: [1090, 1848, 1135, 1966], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '2902', coords: [1135, 1848, 1181, 1966], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '2903', coords: [1183, 1848, 1227, 1966], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '2904', coords: [1229, 1848, 1275, 1966], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '2905', coords: [1275, 1848, 1322, 1966], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '2906', coords: [1323, 1848, 1369, 1966], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '2907', coords: [1368, 1848, 1413, 1966], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '2908', coords: [1415, 1848, 1461, 1966], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '2909', coords: [1462, 1848, 1507, 1966], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '2910', coords: [1507, 1848, 1553, 1966], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '2911', coords: [1089, 1733, 1135, 1847], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '2912', coords: [1135, 1733, 1183, 1847], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '2913', coords: [1183, 1733, 1227, 1847], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '2914', coords: [1228, 1733, 1274, 1847], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '2915', coords: [1276, 1733, 1320, 1847], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '2916', coords: [1322, 1733, 1367, 1847], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '2917', coords: [1367, 1733, 1413, 1847], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '2918', coords: [1415, 1733, 1460, 1847], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '2919', coords: [1461, 1733, 1507, 1847], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '2920', coords: [1507, 1733, 1554, 1847], href: 'link8.html', status: 'V', numero: '20'},              
				// Quadra 32
				{cod: '3201', coords: [558, 41, 605, 197], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '3202', coords: [606, 41, 650, 197], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '3203', coords: [651, 41, 698, 197], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '3204', coords: [699, 41, 744, 197], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '3205', coords: [745, 41, 792, 197], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '3206', coords: [792, 41, 837, 197], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '3207', coords: [838, 41, 885, 197], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '3208', coords: [885, 41, 930, 197], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '3209', coords: [930, 41, 978, 197], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '3210', coords: [978, 41, 1023, 197], href: 'link8.html', status: 'V', numero: '10'},  
                // Quadra 33
				{cod: '3301', coords: [559, 375, 607, 492], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '3302', coords: [608, 375, 653, 492], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '3303', coords: [653, 375, 699, 492], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '3304', coords: [699, 375, 747, 492], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '3305', coords: [747, 375, 793, 492], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '3306', coords: [793, 375, 839, 492], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '3307', coords: [840, 375, 885, 492], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '3308', coords: [887, 375, 931, 492], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '3309', coords: [933, 375, 978, 492], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '3310', coords: [979, 375, 1023, 492], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '3311', coords: [561, 259, 606, 375], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '3312', coords: [607, 259, 652, 375], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '3313', coords: [652, 259, 698, 375], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '3314', coords: [699, 259, 746, 375], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '3315', coords: [747, 259, 793, 375], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '3316', coords: [793, 259, 839, 375], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '3317', coords: [839, 259, 885, 375], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '3318', coords: [885, 259, 931, 375], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '3319', coords: [931, 259, 977, 375], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '3320', coords: [978, 259, 1025, 375], href: 'link8.html', status: 'V', numero: '20'}, 				     
                // Quadra 34
				{cod: '3401', coords: [561, 669, 607, 786], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '3402', coords: [608, 669, 653, 786], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '3403', coords: [654, 669, 699, 786], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '3404', coords: [699, 669, 747, 786], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '3405', coords: [748, 669, 792, 786], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '3406', coords: [793, 669, 840, 786], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '3407', coords: [840, 668, 886, 786], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '3408', coords: [886, 669, 933, 786], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '3409', coords: [933, 669, 981, 786], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '3410', coords: [981, 667, 1025, 786], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '3411', coords: [561, 553, 608, 669], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '3412', coords: [608, 553, 653, 669], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '3413', coords: [653, 553, 699, 669], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '3414', coords: [699, 553, 747, 669], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '3415', coords: [747, 553, 793, 669], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '3416', coords: [793, 553, 839, 669], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '3417', coords: [841, 553, 885, 669], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '3418', coords: [885, 553, 932, 669], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '3419', coords: [932, 553, 979, 669], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '3420', coords: [979, 553, 1025, 669], href: 'link8.html', status: 'V', numero: '20'},				     
                // Quadra 35
				{cod: '3501', coords: [562, 965, 609, 1081], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '3502', coords: [609, 965, 655, 1081], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '3503', coords: [655, 965, 701, 1081], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '3504', coords: [701, 965, 747, 1081], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '3505', coords: [748, 965, 794, 1081], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '3506', coords: [794, 965, 841, 1081], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '3507', coords: [841, 965, 886, 1081], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '3508', coords: [887, 965, 933, 1081], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '3509', coords: [935, 965, 978, 1081], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '3510', coords: [979, 965, 1027, 1081], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '3511', coords: [561, 849, 607, 965], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '3512', coords: [607, 849, 655, 965], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '3513', coords: [655, 849, 701, 965], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '3514', coords: [701, 849, 746, 965], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '3515', coords: [747, 849, 794, 965], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '3516', coords: [795, 849, 840, 965], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '3517', coords: [842, 849, 887, 965], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '3518', coords: [887, 849, 933, 965], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '3519', coords: [934, 849, 979, 965], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '3520', coords: [979, 849, 1027, 965], href: 'link8.html', status: 'V', numero: '20'},			     
                // Quadra 36
				{cod: '3601', coords: [562, 1259, 608, 1377], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '3602', coords: [608, 1259, 654, 1377], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '3603', coords: [654, 1259, 701, 1377], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '3604', coords: [701, 1259, 748, 1377], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '3605', coords: [749, 1259, 796, 1377], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '3606', coords: [796, 1259, 841, 1377], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '3607', coords: [842, 1259, 887, 1377], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '3608', coords: [887, 1259, 934, 1377], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '3609', coords: [934, 1259, 980, 1377], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '3610', coords: [980, 1257, 1026, 1377], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '3611', coords: [562, 1143, 608, 1258], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '3612', coords: [608, 1143, 654, 1258], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '3613', coords: [654, 1143, 700, 1258], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '3614', coords: [700, 1143, 747, 1258], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '3615', coords: [747, 1143, 793, 1258], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '3616', coords: [793, 1143, 840, 1258], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '3617', coords: [842, 1143, 887, 1258], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '3618', coords: [888, 1143, 934, 1258], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '3619', coords: [934, 1143, 980, 1258], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '3620', coords: [980, 1143, 1026, 1258], href: 'link8.html', status: 'V', numero: '20'},			     
                // Quadra 37
				{cod: '3701', coords: [562, 1555, 610, 1671], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '3702', coords: [610, 1555, 655, 1671], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '3703', coords: [656, 1555, 701, 1671], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '3704', coords: [702, 1555, 749, 1671], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '3705', coords: [749, 1555, 794, 1671], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '3706', coords: [794, 1555, 841, 1671], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '3707', coords: [841, 1555, 886, 1671], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '3708', coords: [887, 1555, 934, 1671], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '3709', coords: [934, 1555, 980, 1671], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '3710', coords: [980, 1555, 1028, 1671], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '3711', coords: [562, 1438, 608, 1555], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '3712', coords: [608, 1438, 655, 1555], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '3713', coords: [655, 1438, 700, 1555], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '3714', coords: [701, 1438, 748, 1555], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '3715', coords: [749, 1438, 795, 1555], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '3716', coords: [796, 1438, 842, 1555], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '3717', coords: [842, 1438, 886, 1555], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '3718', coords: [886, 1438, 934, 1555], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '3719', coords: [934, 1438, 980, 1555], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '3720', coords: [980, 1438, 1026, 1555], href: 'link8.html', status: 'V', numero: '20'},			     
                // Quadra 38
				{cod: '3801', coords: [562, 1849, 609, 1966], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '3802', coords: [610, 1849, 654, 1966], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '3803', coords: [655, 1849, 701, 1966], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '3804', coords: [701, 1849, 747, 1966], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '3805', coords: [747, 1849, 795, 1966], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '3806', coords: [795, 1849, 842, 1966], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '3807', coords: [842, 1849, 887, 1966], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '3808', coords: [887, 1849, 935, 1966], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '3809', coords: [935, 1849, 981, 1966], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '3810', coords: [982, 1849, 1028, 1966], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '3811', coords: [562, 1733, 608, 1850], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '3812', coords: [608, 1733, 654, 1850], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '3813', coords: [654, 1733, 702, 1850], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '3814', coords: [702, 1733, 747, 1850], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '3815', coords: [747, 1733, 794, 1850], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '3816', coords: [794, 1733, 841, 1850], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '3817', coords: [841, 1733, 887, 1850], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '3818', coords: [887, 1733, 935, 1850], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '3819', coords: [935, 1733, 979, 1850], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '3820', coords: [980, 1733, 1027, 1850], href: 'link8.html', status: 'V', numero: '20'},			     
                // Quadra 43
				{cod: '4301', coords: [31, 44, 79, 200], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '4302', coords: [79, 44, 125, 200], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '4303', coords: [127, 44, 172, 200], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '4304', coords: [170, 44, 217, 200], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '4305', coords: [219, 44, 265, 200], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '4306', coords: [265, 44, 311, 200], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '4307', coords: [311, 44, 357, 200], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '4308', coords: [357, 44, 403, 200], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '4309', coords: [403, 44, 449, 200], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '4310', coords: [449, 44, 497, 200], href: 'link8.html', status: 'V', numero: '10'},		
                // Quadra 44
				{cod: '4401', coords: [33, 377, 79, 495], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '4402', coords: [81, 377, 127, 495], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '4403', coords: [127, 377, 173, 495], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '4404', coords: [173, 377, 219, 495], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '4405', coords: [220, 377, 266, 495], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '4406', coords: [266, 377, 313, 495], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '4407', coords: [313, 377, 359, 495], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '4408', coords: [359, 377, 404, 495], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '4409', coords: [404, 377, 451, 495], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '4410', coords: [451, 377, 498, 495], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '4411', coords: [32, 261, 78, 378], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '4412', coords: [78, 261, 126, 378], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '4413', coords: [126, 261, 172, 378], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '4414', coords: [172, 261, 220, 378], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '4415', coords: [220, 261, 265, 378], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '4416', coords: [265, 261, 312, 378], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '4417', coords: [312, 261, 357, 378], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '4418', coords: [357, 261, 405, 378], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '4419', coords: [405, 261, 451, 378], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '4420', coords: [451, 261, 497, 378], href: 'link8.html', status: 'V', numero: '20'},				     
                // Quadra 45
				{cod: '4501', coords: [34, 672, 80, 787], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '4502', coords: [81, 672, 127, 787], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '4503', coords: [127, 672, 174, 787], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '4504', coords: [174, 672, 219, 787], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '4505', coords: [219, 672, 266, 787], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '4506', coords: [266, 672, 314, 787], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '4507', coords: [315, 672, 360, 787], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '4508', coords: [360, 672, 406, 787], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '4509', coords: [406, 672, 453, 787], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '4510', coords: [454, 672, 499, 787], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '4511', coords: [33, 556, 79, 672], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '4512', coords: [79, 556, 127, 672], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '4513', coords: [127, 556, 173, 672], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '4514', coords: [173, 556, 219, 672], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '4515', coords: [219, 556, 265, 672], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '4516', coords: [265, 556, 313, 672], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '4517', coords: [313, 556, 357, 672], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '4518', coords: [357, 556, 405, 672], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '4519', coords: [406, 556, 451, 672], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '4520', coords: [451, 556, 498, 672], href: 'link8.html', status: 'V', numero: '20'},				     
                // Quadra 46
				{cod: '4601', coords: [35, 966, 81, 1082], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '4602', coords: [81, 966, 129, 1082], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '4603', coords: [129, 966, 175, 1082], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '4604', coords: [175, 966, 221, 1082], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '4605', coords: [221, 966, 268, 1082], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '4606', coords: [268, 966, 314, 1082], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '4607', coords: [314, 966, 361, 1082], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '4608', coords: [361, 966, 406, 1082], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '4609', coords: [406, 966, 453, 1082], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '4610', coords: [454, 966, 499, 1082], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '4611', coords: [35, 849, 81, 966], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '4612', coords: [81, 849, 128, 966], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '4613', coords: [128, 849, 173, 966], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '4614', coords: [173, 849, 220, 966], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '4615', coords: [220, 849, 267, 966], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '4616', coords: [267, 849, 312, 966], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '4617', coords: [312, 849, 359, 966], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '4618', coords: [359, 849, 406, 966], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '4619', coords: [406, 849, 452, 966], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '4620', coords: [452, 849, 499, 966], href: 'link8.html', status: 'V', numero: '20'},					     
                // Quadra 47
				{cod: '4701', coords: [37, 1259, 82, 1377], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '4702', coords: [82, 1259, 129, 1377], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '4703', coords: [129, 1259, 174, 1377], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '4704', coords: [174, 1259, 222, 1377], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '4705', coords: [222, 1259, 268, 1377], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '4706', coords: [268, 1259, 314, 1377], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '4707', coords: [314, 1259, 361, 1377], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '4708', coords: [361, 1259, 407, 1377], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '4709', coords: [407, 1259, 455, 1377], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '4710', coords: [455, 1259, 501, 1377], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '4711', coords: [36, 1143, 81, 1261], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '4712', coords: [81, 1143, 128, 1261], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '4713', coords: [128, 1143, 174, 1261], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '4714', coords: [174, 1143, 221, 1261], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '4715', coords: [222, 1143, 267, 1261], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '4716', coords: [267, 1143, 316, 1261], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '4717', coords: [315, 1143, 361, 1261], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '4718', coords: [362, 1143, 406, 1261], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '4719', coords: [406, 1143, 455, 1261], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '4720', coords: [455, 1143, 502, 1261], href: 'link8.html', status: 'V', numero: '20'},				     
                // Quadra 48
				{cod: '4801', coords: [35, 1557, 81, 1674], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '4802', coords: [82, 1557, 129, 1674], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '4803', coords: [129, 1557, 175, 1674], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '4804', coords: [175, 1557, 222, 1674], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '4805', coords: [222, 1557, 267, 1674], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '4806', coords: [267, 1557, 315, 1674], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '4807', coords: [315, 1557, 361, 1674], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '4808', coords: [361, 1557, 407, 1674], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '4809', coords: [407, 1557, 455, 1674], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '4810', coords: [455, 1557, 502, 1674], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '4811', coords: [35, 1441, 81, 1557], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '4812', coords: [81, 1441, 129, 1557], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '4813', coords: [129, 1441, 175, 1557], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '4814', coords: [175, 1441, 220, 1557], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '4815', coords: [221, 1441, 267, 1557], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '4816', coords: [266, 1441, 314, 1557], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '4817', coords: [316, 1441, 359, 1557], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '4818', coords: [360, 1441, 407, 1557], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '4819', coords: [408, 1441, 452, 1557], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '4820', coords: [453, 1441, 502, 1557], href: 'link8.html', status: 'V', numero: '20'},			     
                // Quadra 49
				{cod: '4901', coords: [35, 1851, 82, 1969], href: 'link8.html', status: 'V', numero: '01'},
				{cod: '4902', coords: [82, 1851, 129, 1969], href: 'link8.html', status: 'V', numero: '02'},
				{cod: '4903', coords: [129, 1851, 174, 1969], href: 'link8.html', status: 'V', numero: '03'},
				{cod: '4904', coords: [174, 1851, 221, 1969], href: 'link8.html', status: 'V', numero: '04'},
				{cod: '4905', coords: [221, 1851, 268, 1969], href: 'link8.html', status: 'V', numero: '05'},
				{cod: '4906', coords: [268, 1851, 315, 1969], href: 'link8.html', status: 'V', numero: '06'},
				{cod: '4907', coords: [316, 1851, 362, 1969], href: 'link8.html', status: 'V', numero: '07'},
				{cod: '4908', coords: [362, 1851, 409, 1969], href: 'link8.html', status: 'V', numero: '08'},
				{cod: '4909', coords: [409, 1851, 453, 1969], href: 'link8.html', status: 'V', numero: '09'},
				{cod: '4910', coords: [453, 1851, 502, 1969], href: 'link8.html', status: 'V', numero: '10'},
				{cod: '4911', coords: [35, 1734, 81, 1851], href: 'link8.html', status: 'V', numero: '11'},
				{cod: '4912', coords: [81, 1734, 128, 1851], href: 'link8.html', status: 'V', numero: '12'},
				{cod: '4913', coords: [128, 1734, 175, 1851], href: 'link8.html', status: 'V', numero: '13'},
				{cod: '4914', coords: [175, 1734, 221, 1851], href: 'link8.html', status: 'V', numero: '14'},
				{cod: '4915', coords: [221, 1734, 267, 1851], href: 'link8.html', status: 'V', numero: '15'},
				{cod: '4916', coords: [267, 1734, 315, 1851], href: 'link8.html', status: 'V', numero: '16'},
				{cod: '4917', coords: [315, 1734, 362, 1851], href: 'link8.html', status: 'V', numero: '17'},
				{cod: '4918', coords: [362, 1734, 407, 1851], href: 'link8.html', status: 'V', numero: '18'},
				{cod: '4919', coords: [407, 1734, 454, 1851], href: 'link8.html', status: 'V', numero: '19'},
				{cod: '4920', coords: [454, 1734, 500, 1851], href: 'link8.html', status: 'V', numero: '20'},				     
            ];
            

			areas.forEach(area => {
				const [x1, y1, x2, y2] = area.coords;

				const centerX = (x1 + x2) / 2;
				const centerY = (y1 + y2) / 2;

				let fillColor;
				if (area.status === 'D') {
					fillBackColor = "#00BFFF";
					fillColor = "#FFF";
				} else if (area.status === 'V') {
					fillBackColor = "#FF6666";
					fillColor = "#FFF";
				} else if (area.status === 'R') {
					fillBackColor = "yellow";
					fillColor = "#000";
				}

				const linkGroup = g.append("a")
					.attr("href", area.href)  // Define o link para o lote
					.attr("target", "_blank"); // Abre o link em uma nova aba (opcional)

				linkGroup.append("rect")
					.attr("x", x1)
					.attr("y", y1)
					.attr("width", x2 - x1)
					.attr("height", y2 - y1)
					.attr("fill", "transparent") // Retângulo transparente
					.attr("cursor", "pointer"); // Mostra que o retângulo é clicável
                
				linkGroup.append("circle")
					.attr("cx", centerX)
					.attr("cy", centerY)
					.attr("r", 15)
					.attr("fill", fillBackColor);

				linkGroup.append("text")
					.attr("x", centerX)
					.attr("y", centerY + 1)
					.attr("text-anchor", "middle")
					.attr("dominant-baseline", "middle")
					.attr("fill", fillColor)
					.attr("font-size", "15px")
					.text(area.numero);
			});

            const zoom = d3.zoom()
                .scaleExtent([minScale, 10])
                .on("zoom", (event) => {
                    const transform = event.transform;

                    const limitedX = Math.max(Math.min(transform.x, 0), screenWidth - imgWidth * transform.k);
                    const limitedY = Math.max(Math.min(transform.y, 0), window.innerHeight - imgHeight * transform.k);
       
                    // Verifica se a transformação atual está dentro dos limites
                    if (transform.x !== limitedX || transform.y !== limitedY) {
                        // Reseta o evento de transformação para os valores limitados
                        const resetTransform = d3.zoomIdentity.translate(limitedX, limitedY).scale(transform.k);
                        svg.call(zoom.transform, resetTransform);
                    }
                                        
                    g.attr("transform", `translate(${limitedX}, ${limitedY}) scale(${transform.k})`);
                });

            svg.call(zoom).call(zoom.transform, d3.zoomIdentity.translate((screenWidth - imgWidth * initialScale) / 2, 0).scale(initialScale)); // Define a transformação inicial

            window.addEventListener('resize', () => {
                const newWidth = window.innerWidth;
                const newHeight = window.innerHeight;

                svg.attr("width", newWidth).attr("height", newHeight);

                const newTranslateX = (newWidth - imgWidth * initialScale) / 2;
                const newTranslateY = 0;
                svg.call(zoom.transform, d3.zoomIdentity.translate(newTranslateX, newTranslateY).scale(initialScale));
                g.attr("transform", `translate(${newTranslateX}, ${newTranslateY}) scale(${initialScale})`);
            });
        };       
    </script>
</body>
</html>

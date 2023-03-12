import React, { useEffect, useRef, useState } from "react";
import * as d3 from 'd3';

/* Fetch data according to year */
export const fetchSalesByRegionData = async (year: string) => {

    const response = await fetch(`https://localhost/sales_by_region/${year}?page=1`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    if (!response.ok) {
        console.log('Network Error !');
        return [];
    }
    const data = await response.json();
    if (data['hydra:member'].length === 0) return [];

    /* We need to compute percentage so before we make a sum of all sales in order to get the total */
    let sum = 0;
    data['hydra:member'].forEach((element: any) => {
        sum += element.numberSales;
    });

    /* Only 'region' and 'numberSales' are needed so we male an array of JSON Object containing those */
    const reducedData = data['hydra:member'].map((v: any) => {
        return {
            region: v.region,
            salesPercentage: (v.numberSales / sum * 100).toFixed(2),
        }
    });

    /* Sum lower percentages for more readibility in chart */
    let lowPercentageSum = 0;
    let count = 0;
    const result = reducedData.reduce((acc: any, curr: any) => {
        if (parseFloat(curr.salesPercentage) < 5) {
            lowPercentageSum += parseFloat(curr.salesPercentage);
            count++;
        } else {
            acc.push(curr);
        }
        return acc;
    }, []);
    result.push({ region: `Autres (${count} région(s))`, salesPercentage: lowPercentageSum.toString() });

    console.log("DonutChart data:", result)
    return result;
}

export const Donut = ({ width, height }: any) => {
    /* Fetch svg reference */
    const svgRef: any = useRef<SVGSVGElement>(null);
    const [year, setYear] = useState<string>('');
    const [data, setData] = useState<any[]>([]);
    const [loading, setLoading] = useState<boolean>(true);

    useEffect(() => {
        (async () => {
            if (year !== '') setData(await fetchSalesByRegionData(year));
        })();
    }, [year]);

    useEffect(() => {

        if (data.length > 0) setLoading(false);
        else setLoading(true);

        if (!loading) {
            const margin = 40;
            const radius = Math.min(width, height) / 2 - margin;

            /* Remove previous data */
            d3.select(svgRef.current).selectAll('g').remove();

            /* Set svg attributes and append a child to it */
            const svg = d3
                .select(svgRef.current)
                .attr('viewBox', `0 0 ${width / 2} ${width / 2}`)
                .attr('transform', 'translate(0, 25)')
                .append("g")
                .attr("transform", `translate(${Math.min(width, height) / 2}, ${Math.min(width, height) / 2})`);

            /* Create the pie */
            const pie: any = d3
                .pie()
                .value((d: any) => d.salesPercentage)

            /* Use data values */
            const ready = pie(data);

            /* Generate random colors stored in array with same size as data */
            const colors: any = d3
                .scaleOrdinal()
                .range(data.map((v: any) => '#' + Math.random().toString(16).slice(-6)));

            /* Create arc */
            const arc: any = d3
                .arc()
                .innerRadius(radius * 0.8)
                .outerRadius(radius * 0.5);

            /* Create arc for each data value */
            svg
                .selectAll('parts')
                .data(ready)
                .enter()
                .append('path')
                .attr('d', arc)
                .attr('fill', (d: any, i: number) => colors(i))
                .style("opacity", 0.7);

            /* Arc for labels */
            const legend = d3
                .arc()
                .innerRadius(radius * 0.8)
                .outerRadius(radius * 0.5);

            /* Creating lines */
            svg
                .selectAll('lines')
                .data(ready)
                .enter()
                .append('polyline')
                .attr("stroke", "black")
                .style("fill", "none")
                .attr("stroke-width", 1)
                .attr('points', (d: any) => {
                    const pos = arc.centroid(d); // used for line insertion
                    const pos2 = legend.centroid(d); // used for line break
                    const copy = pos; // copy of pos2 but with first value changed later
                    const mid = d.startAngle + (d.endAngle - d.startAngle) / 2; // if the X position is at the extreme right or extreme left
                    copy[0] = radius * 0.95 * (mid < Math.PI ? 1 : -1); // put it on the left or on the right by multplying by 1 or -1
                    return [pos, pos2, copy];
                })

            /* Add lines between chart and label */
            svg
                .selectAll('labels')
                .data(ready)
                .enter()
                .append('text')
                .text((d: any) => `${d.data.region}: ${d.data.salesPercentage}%`)
                .attr('transform', (d: any) => {
                    const pos = arc.centroid(d);
                    const mid = d.startAngle + (d.endAngle - d.startAngle) / 2
                    pos[0] = radius * 0.99 * (mid < Math.PI ? 1 : -1);
                    return `translate(${pos})`;
                })
                .style('text-anchor', (d: any) => {
                    const mid = d.startAngle + (d.endAngle - d.startAngle) / 2
                    return (mid < Math.PI ? 'start' : 'end')
                })
        }

    }, [data, height, loading, width]);

    const selectedYear = (event: any) => {
        setYear(event.target.value);
    };

    return (
        <>
            <select className="graphs-select" onChange={selectedYear}>
                <option>-- Choisissez une année --</option>
                <option value={'2018'}>2018</option>
                <option value={'2019'}>2019</option>
                <option value={'2020'}>2020</option>
                <option value={'2021'}>2021</option>
            </select>
            {data.length === 0 ?
                <h2 className="graphs-nodata">Aucune donnée trouvée !</h2>
                :
                <>
                    {
                        loading ?
                            <h2 className="graphs-load">Chargement...</h2>
                            :
                            <>
                                <h1 className="graphs-title">Répartition des ventes par région sur l'année {year}</h1>
                                <div className="graphs-graph-donut">
                                    <svg ref={svgRef} width={width} height={height} />
                                </div>
                            </>
                    }
                </>
            }
        </>

    );
};

export default function DonutChart(props: any) {

    return (
        <div>
            <Donut width={props.width} height={props.height} />
        </div>
    )
}

import React, { useEffect, useRef, useState } from "react";
import * as d3 from 'd3';

export const fetchAveragePriceData = async () => {
    const response = await fetch(`https://localhost/average_price_per_month?page=1`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    if (!response.ok) {
        console.log('Data not found !');
        return [];
    }
    const data = await response.json();
    const res = data['hydra:member'].map((v: any) => {
        const split = v.date.split('T')[0];
        return {
            date: split.substring(0, split.indexOf('-')),
            averagePrice: v.averagePrice
        }
    });
    
    console.log("LineChart data:", res)
    return res;
}

export const Line = ({ width, height }: any) => {
    const svgRef: any = useRef<SVGSVGElement>(null);
    const [data, setData] = useState<any[]>([]);
    const [loading, setLoading] = useState<boolean>(true);

    useEffect(() => {
        (async () => {
            setData(await fetchAveragePriceData());
        })();
    }, []);

    useEffect(() => {

        if (data.length > 0) setLoading(false);
        else setLoading(true);

        if (!loading) {
            const margin = {
                top: 20,
                right: 20,
                bottom: 20,
                left: 20,
            };

            const w = width - margin.left - margin.right;
            const h = height - margin.top - margin.bottom;

            const svg = d3
                .select(svgRef.current)
                .attr("transform", `translate(100, 100)`)
                .attr('viewBox', `0 0 ${width / 1.7} ${width / 1.7}`);

            const everything = svg.selectAll("*");
            everything.remove();

            const X: any = d3
                .scaleBand()
                .domain(data.map((d: any) => d.date))
                .rangeRound([0, w])
                .padding(0.1);

            svg
                .append('g')
                .attr("orient", "bottom")
                .attr("transform", `translate(0, ${h})`)
                .call(d3.axisBottom(X))
                .append("text")
                .attr('font-size', 16)
                .attr("y", margin.bottom * 2)
                .attr("x", width / 2)
                .attr("text-anchor", "end")
                .attr("fill", "black")
                .text("Année");

            const yDomain: any[] = d3.extent(data, (d: any) => d.averagePrice);
            const Y: any = d3
                .scaleLinear()
                .domain(yDomain)
                .range([h, 0])
                .nice();

            svg
                .append("g")
                .attr("orient", "left")
                .attr("transform", `translate(0, 0)`)
                .call(d3.axisLeft(Y).ticks(6))
                .append("text")
                .attr('font-size', 32)
                .attr("transform", "rotate(-90)")
                .attr('x', -width / 4)
                .attr("y", margin.top * 4)
                .attr("dy", "-5.1em")
                .attr("text-anchor", "middle")
                .attr("fill", "black")
                .text("Prix moyen du m²");

            const line = d3
                .line<{
                    x: string,
                    y: number
                }>()
                .x((d: any) => X(d.date))
                .y((d: any) => Y(d.averagePrice))
                .curve(d3.curveMonotoneX);

            svg
                .append("path")
                .datum(data)
                .join("path")
                .attr("class", "line")
                .attr("fill", "none")
                .attr("stroke", "steelblue")
                .attr("stroke-width", 1.5)
                .attr("d", line);
        }


    }, [loading, height, width, data]);

    return (
        <>
            {loading ?
                <h2 className="graphs-load">Chargement...</h2>
                :
                <>
                    <h1 className="graphs-title">Évolutions du prix de vente moyen du mètre carré pour les ventes entre 2018 et 2021</h1>
                    <div className="graphs-graph-line">
                        <svg ref={svgRef} width={width} height={height} />
                    </div>
                </>
            }
        </>
    );
};

export default function LineChart(props: any) {

    return (
        <div>
            <Line width={props.width} height={props.height} />
        </div>
    )
}

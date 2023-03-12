import React, { useEffect, useRef, useState } from "react";
import * as d3 from 'd3';

/* Just for aestheticism for message */
export const timeMessage = (confirmed: boolean, time: string, start: string, end: string) => {
    if (confirmed || (time === '' || start === '' || end === '')) return 'Chargement...';
    if (time === 'day') return `Vente(s) quotidienne(s) par mois entre le ${start} et le ${end}`;
    if (time === 'month') return `Ventes(s) mensuelle(s) entre le ${start} et le ${end}`;
    if (time === 'year') return `Vente(s) annuelle(s) entre le ${start} et le ${end}`;
    return '';
}

export const fetchNumberOfSalesData = async (states: any) => {
    const [type, startingDate, endingDate] = states;
    const response = await fetch(`https://localhost/number_sales_by_date/${type}/${startingDate}/${endingDate}?page=1`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    if (!response.ok) {
        console.log('Data not found !');
        return [];
    }

    const dateFormat = (datetype: string, datetext: string) => {
        if (datetype === 'day') return datetext.substring(datetext.lastIndexOf('-') + 1);
        if (datetype === 'month') return datetext.substring(0, datetext.lastIndexOf('-'));
        if (datetype === 'year') return datetext.substring(0, datetext.indexOf('-'));
        return '';
    }

    const data = await response.json();
    if (data['hydra:member'].length === 0) return [];

    const reducedData = data['hydra:member'].map((v: any) => {
        const date = dateFormat(type, v.date.split('T')[0]);
        return {
            date: date,
            numberSales: v.numberSales
        }
    });

    console.log("BarChart data:", reducedData)
    return reducedData;

}

export const Bar = ({ width, height }: any) => {
    const svgRef: any = useRef<SVGSVGElement>(null);
    const [type, setType] = useState<string>('');
    const [startingDate, setStartingDate] = useState<string>('');
    const [endingDate, setEndingDate] = useState<string>('');
    const [data, setData] = useState<any[]>([]);
    const [loading, setLoading] = useState<boolean>(true);
    const [confirmed, setConfirmed] = useState<boolean>(false);

    useEffect(() => {
        (async () => {
            if (confirmed) {
                setData(await fetchNumberOfSalesData([type, startingDate, endingDate]));
                setConfirmed(false);
            }
        })();
    }, [confirmed, endingDate, startingDate, type]);

    useEffect(() => {

        if (data.length > 0) setLoading(false);
        else setLoading(true);

        if (!loading) {
            const margin = { top: 10, right: 10, bottom: 20, left: 40 };
            const w = width - margin.left - margin.right;
            const h = height - margin.top - margin.bottom;

            /* Remove previous data */
            d3.select(svgRef.current).selectAll('g').remove();
            d3.select(svgRef.current).selectAll('.bar').remove();
            d3.select(svgRef.current).selectAll('.bar-label').remove();

            const svg = d3
                .select(svgRef.current)
                .attr('transform', `translate(0, 100)`)
                .attr('viewBox', `0 0 ${width / 1.5} ${width / 1.5}`);

            const xScale: any = d3
                .scaleBand()
                .domain(data.map((d: any) => d.date))
                .range([0, w]);

            const X = d3
                .axisBottom(xScale);

            svg
                .append('g')
                .attr('class', 'x-axis')
                .attr('transform', `translate(0, ${h})`)
                .call(X)
                .append("text")
                .attr('font-size', 16)
                .attr("y", margin.bottom * 2)
                .attr("x", width / 2)
                .attr("text-anchor", "end")
                .attr("fill", "black")
                .text("Date");

            const yDomain: any[] = [0, d3.max(data, (d: any) => d.numberSales) * 1.1];
            const yScale: any = d3
                .scaleLinear()
                .domain(yDomain)
                .range([h, 0])
                .nice();

            const Y = d3
                .axisLeft(yScale)
                .tickFormat((d: any) => `${d}`)
                .ticks(10);

            svg
                .append('g')
                .attr('class', 'y-axis')
                .call(Y)
                .append("text")
                .attr('font-size', 32)
                .attr("transform", "rotate(-90)")
                .attr('x', -margin.left * 4)
                .attr("y", margin.top * 4)
                .attr("dy", "-5.1em")
                .attr("text-anchor", "middle")
                .attr("fill", "black")
                .text("Nombre de ventes");

            const colorScale: any = d3
                .scaleOrdinal()
                .range(data.map((v: any) => '#' + Math.random().toString(16).slice(-6)));

            svg
                .selectAll('.bar')
                .data(data)
                .enter()
                .append('rect')
                .attr('class', 'bar')
                .attr('stroke', 'black')
                .attr('x', (d: any) => xScale(d.date))
                .attr('y', (d: any) => yScale(d.numberSales))
                .attr('height', (d: any) => (h - yScale(d.numberSales)))
                .attr('width', _ => xScale.bandwidth())
                .style('fill', (d: any, i: number) => colorScale(i));
        }

    }, [data, height, loading, width]);

    const selectedType = (event: any) => {
        setType(event.target.value);
    };

    const selectedStartingDate = (event: any) => {
        setStartingDate(event.target.value);
    }

    const selectedEndingDate = (event: any) => {
        setEndingDate(event.target.value);
    }

    const confirmChoices = (event: any) => {
        if (type != '' && startingDate != '' && endingDate != '') {
            const d1: Date = new Date(startingDate);
            const d2: Date = new Date(endingDate);
            if (d1 > d2) return alert('La date de départ doit être inférieure ou égale à celle d\'arrivée');
            setConfirmed(true);
        }
        else setConfirmed(false);
    }

    return (
        <>
            <select className="graphs-select" onChange={selectedType}>
                <option>-- Choisissez entre jour, mois et année --</option>
                <option value={'day'}>Jour</option>
                <option value={'month'}>Mois</option>
                <option value={'year'}>Année</option>
            </select>
            {type != '' ?
                <div>
                    <label className="graphs-label">De</label>
                    <input className="graphs-input" type='date' min="2018-01-01" max="2021-12-31" onChange={selectedStartingDate} />
                    <label className="graphs-label">à</label>
                    <input className="graphs-input" type='date' min="2018-01-01" max="2021-12-31" onChange={selectedEndingDate} />
                </div>
                : null
            }
            <button className="graphs-button" onClick={confirmChoices}>Confirmer</button>
            {data.length === 0 ?
                <h2 className="graphs-nodata">Aucune donnée trouvée !</h2>
                :
                <>
                    {
                        loading ?
                            <h2 className="graphs-load">Chargement...</h2>
                            :
                            <>
                                <h1 className="graphs-title">{timeMessage(confirmed, type, startingDate, endingDate)}</h1>
                                <div className="graphs-graph-bar">
                                    <svg ref={svgRef} width={width} height={height} />
                                </div>
                            </>
                    }
                </>
            }
        </>
    );
};

export default function BarChart(props: any) {

    return (
        <div>
            <Bar width={props.width} height={props.height} />
        </div>
    )
}

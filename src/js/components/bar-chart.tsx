export class BarChartTest extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    const data = this.dataset.chart;

    if (data) {
      try {
        Promise.all([
          import("react"),
          import("react-dom/client"),
          import("recharts"),
        ]).then(([React, ReactDOM, Recharts]) => {
          const chartData = JSON.parse(data);
          const root = ReactDOM.createRoot(this);

          const { BarChart, Bar, LabelList, ResponsiveContainer } = Recharts;

          root.render(
            <ResponsiveContainer width="100%" height="100%">
              <BarChart
                width={200}
                height={40}
                barGap={18}
                data={[
                  chartData.reduce((acc, { name, value }) => {
                    acc[name] = value;
                    return acc;
                  }, {}),
                ]}
                margin={{ top: 0, right: -30, bottom: 0, left: -30 }}
              >
                {chartData.map((data) => (
                  <Bar dataKey={data.name} fill="#008dc5">
                    <LabelList
                      dataKey={data.name}
                      content={renderCustomizedLabel}
                    />
                  </Bar>
                ))}
              </BarChart>
            </ResponsiveContainer>,
          );
        });
      } catch (e) {
        console.error("Invalid chart data", e);
      }
    }
  }
}

const renderCustomizedLabel = ({ x, y, width, value }) => {
  return (
    <text
      x={x + width / 2}
      y={y - 14}
      fill="#333"
      textAnchor="middle"
      dominantBaseline="middle"
      fontSize={16}
    >
      {value}
    </text>
  );
};

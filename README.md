# parse-chinese-text

Chinese (here always referring to Mandarin Chinese written in Simplified Characters) does not have spaces between words so parsing it is not trivial.  Words can be one character long or up to four or five.  One feature though is that shorter words are more common.  

One method often used is a dictionary lookup, which is what I use here.  Essentially you block off a group of characters (say 5) and see if you can find that word it in the dictionary.  If not, you cut off one character, and try again, up until you are left with one character, in which case it either isn't a Chinese character (could be a Latin letter or a question mark), or it is, but you have your boundary.  Move to the next five characters and repeat.

This isn't a perfect solution, and it will parse wrong at times, because it does not take grammar and context into consideration.  But it gets the job done for many purposes.  For me it was in the in a project where we needed to classify Chinese text into categories.  This was mostly done by looking at word frequencies.  An occasional mis-parsing is unlikely to influence topical categorization: if the text is about airplanes, it's likely airplanes will be mentioned more than once.

Load entire Chinese dictionary into memory?  Sure.  The dictionary I use below is 2 MB and has 44,783 Chinese words including translations and both simplified and complex characters.  When you take out only Simplified Characters, which is only what you need, the entire dictionary is 370 KB!  Yes, you can safely load it into memory.

Dictionary was downloaded from here: http://cgibin.erols.com/mandarintools/cedict.html

Converted to only Mandarin words, one word per line with:
<pre><b>cat cedict_ts.u8 | cut -d" " -f2 > mandarin_words.txt</b></pre>

Note the challanges of working with UTF-8 strings, for example in functions like <b>strlen</b> or <b>substr</b>.  Using <b>mb_</b> versions.

Example of a script parsestdin.php using the function to read text from STDIN and output parsed text to STDOUT.

<pre>
<i>nik@nik-laptop:~/Dropbox/Lab/Chinese$</i> <b>cat sample1.txt | ./parsestdin.php</b>
《 | 南方周末 | 》 | 每周 | 四 | 出版 | ， | 全国 | 发行 | 。 | 创办 | 于 | 1 | 9 | 8 | 4 | 年 | ， | 以 | “ | 在 | 这里 |
， | 读 | 懂 | 中国 | ” | 为 | 办报 | 宗旨 | ， | 以 | “ | 正义 | 、 | 良 | 知 | 、 | 爱 | 心 | 、 | 理性 | ” | 为 | 基本 |
理念 | 。 | 南方周末 | 是 | 中国 | 深 | 具 | 公 | 信 | 力 | 的 | 严肃 | 大 | 报 | ， | 是 | 中国 | 发行 | 量 | 最大 | 的 |
新闻 | 周 | 报 | ， | 覆盖 | 全国 | 各 | 大 | 中 | 城市 | ， | 每 | 期 | 发行 | 量 | 稳定 | 在 | 1 | 2 | 0 | 万 | 份 | 以上
| ， | 核心 | 读者 | 群 | 为 | 知识 | 型 | 读者 | 。 | 南方 | 报 | 业 | 传 | 媒 | 集团 | 旗 | 下 | 一 | 份 | 享 | 誉 | 海 |
内 | 外 | 的 | 综合 | 类 | 周 | 报 | ， | 也 | 是 | 中国 | 发行 | 量 | 最大 | 、 | 传 | 阅 | 率 | 高 | 、 | 影响 | 最 |
广泛 | 、 | 公 | 信 | 力 | 强 | 的 | 新闻 | 周 | 报 | 。 | 从 | 2 | 0 | 世纪 | 9 | 0 | 年代 | 到 | 2 | 1 | 世纪 | ， |
南方周末 | 坚持 | 大新 | 闻 | 概念 | ， | 站 | 在 | 时代 | 的 | 高度 | ， | 以 | 广阔 | 的 | 视野 | ， | 在 | 党 | 的 |
新闻 | 工作 | 要求 | 和 | 马克思主义 | 新闻 | 观 | 的 | 指导 | 下 | ， | 认真 | 执行 | “ | 积极 | 、 | 正 | 向 | 、 | 均衡
| 、 | 稳健 | ” | 的 | 编辑 | 方针 | 。 | 南方周末 | 每 | 期 | 3 | 2 | 版 | ， | 分 | 新闻 | 、 | 经济 | 、 | 文化 | 三 |
大 | 板块 | ， | 内容 | 紧 | 扣 | 时代 | 发展 | 得 | 热 | 点 | 与 | 焦点 | ， | 通过 | 全面 | 、 | 深入 | 、 | 生动 | 地 |
反映 | 和 | 报道 | 新近 | 发生 | 的 | 重大 | 事实 | ， | 向 | 广大 | 读者 | 提供 | 更 | 完整 | 、 | 真实 | 的 | 中国 | 社会
| 迈 | 向 | 未来 | 的 | 脉 | 络 | 、 | 趋势 | 和 | 图 | 景 | 。 | 
 | 《 | 南方周末 | 》 | 荣获 | “ | 2 | 0 | 0 | 3 | 艾 | 菲 | 广告 | 实 | 效 | 奖 | ” | ， | 是 | 第一 | 个 | 获得 | 国际 |
 营 | 销 | 大奖 | 的 | 中国 | 报纸 | 。 | 2 | 0 | 0 | 6 | 年 | ， | 世界 | 品牌 | 实验室 | （ | W | B | L | ） | 公布 | 的
 | 《 | 中国 | 5 | 0 | 0 | 最 | 具 | 价值 | 品牌 | 》 | 中 | ， | 南方周末 | 以 | 2 | 0 | 亿 | 元 | 的 | 品牌 | 价值 | 位 |
 居 | 周 | 报 | 第一 | 名 | 。 | 2 | 0 | 0 | 8 | 年 | ， | 南方周末 | 在 | 由 | 中国 | 商务 | 广告 | 协会 | 和 | 中国 | 传
 | 媒 | 大学 | 主办 | 的 | “ | 2 | 0 | 0 | 8 | 中国 | 消费者 | 理想 | 品牌 | 大 | 调查 | ” | 中 | ， | 位 | 列 | 报纸 | 类
 | “ | 理想 | 品牌 | ” | 第一 | 位 | 。 |  | 
</pre>

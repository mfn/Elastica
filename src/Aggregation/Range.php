<?php

namespace Elastica\Aggregation;

use Elastica\Exception\InvalidException;

/**
 * Class Range.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-range-aggregation.html
 */
class Range extends AbstractSimpleAggregation
{
    /**
     * Add a range to this aggregation.
     *
     * @param float|int $fromValue low end of this range, exclusive (greater than or equal to)
     * @param float|int $toValue   high end of this range, exclusive (less than)
     * @param string    $key       customized key value
     *
     * @throws \Elastica\Exception\InvalidException
     *
     * @return $this
     */
    public function addRange($fromValue = null, $toValue = null, ?string $key = null): self
    {
        if (null === $fromValue && null === $toValue) {
            throw new InvalidException('Either fromValue or toValue must be set. Both cannot be null.');
        }

        $range = [];

        if (null !== $fromValue) {
            $range['from'] = $fromValue;
        }

        if (null !== $toValue) {
            $range['to'] = $toValue;
        }

        if (null !== $key) {
            $range['key'] = $key;
        }

        return $this->addParam('ranges', $range);
    }

    /**
     * If set to true, a unique string key will be associated with each bucket, and ranges will be returned as an associative array.
     *
     * @return $this
     */
    public function setKeyed(bool $keyed): self
    {
        return $this->setParam('keyed', $keyed);
    }

    /**
     * @return $this
     *
     * @deprecated singe version 7.1.0, use the "setKeyed()" method instead.
     */
    public function setKeyedResponse(bool $keyed = true): self
    {
        trigger_deprecation('ruflin/elastica', '7.1.0', 'The "%s()" method is deprecated, use "setKeyed()" instead. It will be removed in 8.0.', __METHOD__);

        return $this->setKeyed($keyed);
    }
}
